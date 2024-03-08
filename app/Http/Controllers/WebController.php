<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\Web;
use App\Models\WebCategory;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    public function catpage($department_id, $category_id)
    {
        $category  = WebCategory::findOrFail($category_id);
        $webs = $category->webs()->where('category_id', $category_id)->get();
        $sortedCategory = $webs->sortBy('sort');
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.category.index', ['webs' => $sortedCategory, 'category' => $category, 'depart' => $depart]);
    }

    public function create($department_id, $category_id)
    {
        $category  = WebCategory::findOrFail($category_id);
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.category.create', compact('category', 'depart'));
    }

    public function store(Request $request, $department_id, $category_id)
    {

        $category  = WebCategory::findOrFail($category_id);
        $validator = Validator::make($request->all(), [
            'web_th' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }


        $lastSort = Web::where('category_id', $category_id)->max('sort');
        $newSort = $lastSort + 1;
        $lastid = Web::max('web_id');
        $newid = $lastid + 1;
        $webs = new Web;
        $webs->web_id = $newid;
        $webs->web_th = $request->web_th;
        $webs->web_en = $request->web_en;
        $webs->web_date = now();
        $webs->web_status = $request->input('web_status', 0);
        $webs->web_type = 0;
        $webs->recommended = $request->input('recommended', 0);
        $webs->sort = $newSort;;
        $webs->web_option = null;
        $webs->category_id = (int)$category_id;
        if ($category->category_type == 2) {
            if ($request->startdate) {
                $webs->startdate = $request->startdate;
            } else {
                $webs->startdate = null;
            }
            if ($request->enddate) {
                $webs->enddate = $request->enddate;
            } else {
                $webs->enddate = null;
            }
        }


        if (!file_exists(public_path('/upload/Web/ck/'))) {
            mkdir(public_path('/upload/Web/ck/'), 0755, true);
        }
        
        if ($request->has('detail_th')) {
            $detail_th = $request->detail_th;
            $decodedTextdetail_th = '';
            if (!empty($detail_th)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // Set encoding to UTF-8
                $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
                $detail_th = preg_replace('/<img\s[^>]*\b0x20\b[^>]*>/', '', $detail_th);
                $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);
                $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                libxml_use_internal_errors(false); // Enable internal error handling
                libxml_clear_errors(); // Clear any accumulated errors
                $images_des_th = $de_th->getElementsByTagName('img');
                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Web/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail_th = $de_th->saveHTML();
                $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
            }

            $webs->detail_th = $decodedTextdetail_th;
        }

        if ($request->has('detail_en')) {
            $detail_en = $request->detail_en;
            $decodedTextdetail_en = '';
            if (!empty($detail_en)) {
                $de_en = new DOMDocument();
                $de_en->encoding = 'UTF-8'; // Set encoding to UTF-8
                $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
                $detail_en = preg_replace('/<img\s[^>]*\b0x20\b[^>]*>/', '', $detail_en);
                $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
                libxml_use_internal_errors(true); // Enable internal error handling
                $de_en->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors(); // Clear any accumulated errors
                $images_de_en = $de_en->getElementsByTagName('img');

                foreach ($images_de_en as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Web/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail_en = $de_en->saveHTML();
                $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
            }


            $webs->detail_en = $decodedTextdetail_en;
        }

        $webs->save();

        if ($request->hasFile('cover')) {
            $file_name = 'cover' .  $webs->web_id  . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Web/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Web/' . $file_name), file_get_contents($request->cover));
                $webs->cover = 'upload/Web/' . $file_name;
                $webs->save();
            }
        } else {
            $file_name = '';
            $webs->cover = $file_name;
            $webs->save();
        }

        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');

            $userAgent = $request->header('User-Agent');
        }
        $conditions = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh|Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad|iPod',
        ];

        $os = '';

        // Loop through the conditions and check the user agent for the operating system
        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break; // Exit the loop once a match is found
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
        }


        if ($loginId) {
            $loginLog = Log::where('user_id', $loginId)->where('logaction', 2)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 2;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->user_id = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();
        DB::commit();

        return redirect()->route('catpage', ['department_id' => $department_id, 'category_id' => $webs->category_id])->with('message', 'Data create successfully');
    }
    public function edit($department_id, $web_id)
    {
        $webs = Web::findOrFail($web_id);
        $category_id = $webs->category_id;
        $category  = WebCategory::findOrFail($category_id);
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);

        return view('page.manages.even.category.edit', compact('webs', 'category', 'depart'));
    }
    public function update(Request $request, $department_id, $web_id)
    {
        $request->validate([
            'web_th' => 'required'

        ]);
        $webs = Web::findOrFail($web_id);
        if ($request->hasFile('cover')) {
            $file_name = 'cover' .  $web_id  . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Web/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Web/' . $file_name), file_get_contents($request->cover));
                $webs->cover = 'upload/Web/' . $file_name;
            }
        }

        $webs->web_th = $request->web_th;
        $webs->web_en = $request->web_en;
        if ($request->startdate) {
            $webs->startdate = $request->startdate;
        }
        if ($request->enddate) {
            $webs->enddate = $request->enddate;
        }
        $webs->web_update = now();
        $webs->web_status = $request->input('web_status', 0);
        $webs->recommended = $request->input('recommended', 0);

        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/upload/Web/ck/'))) {
            mkdir(public_path('/upload/Web/ck/'), 0755, true);
        }
        if ($request->has('detail_th')) {
            $detail_th = $request->detail_th;
            $decodedTextdetail_th = '';
            if (!empty($detail_th)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // Set encoding to UTF-8
                $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
                $detail_th = preg_replace('/<img\s[^>]*\b0x20\b[^>]*>/', '', $detail_th);
                $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);

                libxml_use_internal_errors(true); // Enable internal error handling
                $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors(); // Clear any accumulated errors
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Web/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }

                libxml_clear_errors(); // ล้างข้อผิดพลาดที่เกิดขึ้น
                $detail_th = $de_th->saveHTML();
                $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
            }

            $webs->detail_th = $decodedTextdetail_th;
        }

        if ($request->has('detail_en')) {
            $detail_en = $request->detail_en;
            $decodedTextdetail_en = '';
            if (!empty($detail_en)) {
                $de_en = new DOMDocument();
                $de_en->encoding = 'UTF-8'; // Set encoding to UTF-8
                $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
                $detail_en = preg_replace('/<img\s[^>]*\b0x20\b[^>]*>/', '', $detail_en);
                $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
                libxml_use_internal_errors(true); // Enable internal error handling
                $de_en->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors(); // Clear any accumulated errors

                $images_de_en = $de_en->getElementsByTagName('img');

                foreach ($images_de_en as $key2 => $img2) {
                    if (strpos($img2->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img2->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Web/ck/' . time() . $key2 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img2->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img2->setAttribute('src', $newImageUrl);
                    }
                }

                libxml_clear_errors(); // ล้างข้อผิดพลาดที่เกิดขึ้น
                $detail_en = $de_en->saveHTML();
                $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
            }

            $webs->detail_en = $decodedTextdetail_en;
        }

        $webs->save();


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');

            $userAgent = $request->header('User-Agent');
        }
        $conditions = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh|Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad|iPod',
        ];

        $os = '';

        // Loop through the conditions and check the user agent for the operating system
        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break; // Exit the loop once a match is found
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
        }


        if ($loginId) {
            $loginLog = Log::where('user_id', $loginId)->where('logaction', 3)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 3;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->user_id = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();

        return redirect()->route('catpage', ['department_id' => $department_id, 'category_id' => $webs->category_id])->with('message', 'Data update successfully');
    }

    public function destroy($web_id)
    {
        $webs = Web::findOrFail($web_id);

        $webs->delete();
        return redirect()->back()->with('message', 'Data delete successfully');
    }


    public function changeStatus(Request $request)
    {
        $web = Web::find($request->web_id);

        if ($web) {
            $web->web_status = $request->web_status;
            $web->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล web']);
        }
    }
    public function changeSortWeb(Request $request)
    {
        $wed = Web::find($request->web_id);

        if ($wed) {
            $wed->sort = $request->sort;
            $wed->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล wed']);
        }
    }
}
