<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CourseSubject;
use App\Models\Department;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categoryac($department_id, $subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $catac = $subs->Catt()->where('subject_id', $subject_id)->get();
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.activitys.activcontent.catego.index', compact('subs', 'catac', 'depart'));
    }

    public function create($department_id, $subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $catac = $subs->Catt()->where('subject_id', $subject_id)->get();
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.activitys.activcontent.catego.create', compact('subs', 'catac', 'depart'));
    }

    public function store(Request $request, $department_id, $subject_id)
    {

        $validator = Validator::make($request->all(), [
            'category_th' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try {
            $catac = new Category;

            $catac->category_th = $request->category_th;
            $catac->category_en = $request->category_en;
            libxml_use_internal_errors(true);
        
            if (!Storage::disk('sftp')->exists('/catac/Dp/ck/')) {
                Storage::disk('sftp')->makeDirectory('/catac/Dp/ck/');
            }
         
            if ($request->has('detail_th')) {
                $detail_th = $request->detail_th;
                $decodedTextdetail_th = '';
                if (!empty($detail_th)) {
                    $de_th = new DOMDocument();
                    $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
                    $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);
                    $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images_des_th = $de_th->getElementsByTagName('img');

                    foreach ($images_des_th as $key => $img) {
                        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                            $image_name = '/upload/catac/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                            Storage::disk('sftp')->put($image_name, $data);
                            $img->removeAttribute('src');
                            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                            $img->setAttribute('src', $newImageUrl);
                        }
                    }
                    $detail_th = $de_th->saveHTML();
                    $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
                }

                $catac->detail_th = $decodedTextdetail_th;

            }
            if ($request->has('detail_en')) {
                $detail_en = $request->detail_en;
                $decodedTextdetail_en = '';
                if (!empty($detail_en)) {
                    $de_e = new DOMDocument();
                    $de_e->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
                    $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
                    $de_th->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images_de_e = $de_e->getElementsByTagName('img');

                    foreach ($images_de_e as $key => $img) {
                        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                            $image_name = '/upload/catac/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                            Storage::disk('sftp')->put($image_name, $data);
                            $img->removeAttribute('src');
                            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                            $img->setAttribute('src', $newImageUrl);
                        }
                    }
                    $detail_en = $de_e->saveHTML();
                    $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
                }

                $catac->detail_en = $decodedTextdetail_en;
            }
            $catac->category_date = now();
            $catac->category_update = null;
            $catac->category_status = $request->input('category_status', 0);
            $catac->recommended = $request->input('recommended', 0);
            $catac->category_type = 0;
            $catac->category_option = '';

            $catac->subject_id = (int)$subject_id;
            $catac->save();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
        }
        return redirect()->route('categoryac', [$department_id, 'subject_id' => $subject_id])->with('message', 'Category บันทึกข้อมูลสำเร็จ');
    }
    public function edit($department_id, $category_id)
    {
        $catac  = Category::findOrFail($category_id);
        $subject_id =  $catac->subject_id;
        $subs  = CourseSubject::findOrFail($subject_id);
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.activitys.activcontent.catego.edit', compact('catac', 'depart', 'subs'));
    }
    public function update(Request $request, $department_id, $category_id)
    {

        $catac  = Category::findOrFail($category_id);

        $catac->category_th = $request->category_th;
        $catac->category_en = $request->category_en;
        libxml_use_internal_errors(true);
        if (!Storage::disk('sftp')->exists('/catac/Dp/ck/')) {
            Storage::disk('sftp')->makeDirectory('/catac/Dp/ck/');
        }
      
        if ($request->has('detail_th')) {
            $detail_th = $request->detail_th;
            $decodedTextdetail_th = '';
            if (!empty($detail_th)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
                $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);
                $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/catac/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        Storage::disk('sftp')->put($image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                        $img->setAttribute('src', $newImageUrl);

                    }
                }
                $detail_th = $de_th->saveHTML();
                $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
            }

            $catac->detail_th = $decodedTextdetail_th;
        }
        if ($request->has('detail_en')) {
            $detail_en = $request->detail_en;
            $decodedTextdetail_en = '';
            if (!empty($detail_en)) {

                $de_e = new DOMDocument();
                $de_e->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
                $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
                $de_th->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_de_e = $de_e->getElementsByTagName('img');

                foreach ($images_de_e as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/catac/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        Storage::disk('sftp')->put($image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail_en = $de_e->saveHTML();
                $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
            }

            $catac->detail_en = $decodedTextdetail_en;
        }

        $catac->category_update = now();
        $catac->category_status = $request->input('category_status', 0);
        $catac->recommended = $request->input('recommended', 0);


        $catac->save();


        return redirect()->route('categoryac', [$department_id, 'subject_id' => $catac->subject_id])->with('message', 'Category บันทึกข้อมูลสำเร็จ');
    }
    public function destroy($category_id)
    {

        $catac  = Category::findOrFail($category_id);

        $catac->delete();


        return redirect()->back()->with('message', 'Category ลบสำเร็จ');
    }


    public function changeStatuCategory(Request $request)
    {
        $catac = Category::find($request->category_id);

        if ($catac) {
            $catac->category_status = $request->category_status;
            $catac->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Category']);
        }
    }
}
