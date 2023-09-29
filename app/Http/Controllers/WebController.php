<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\Web;
use App\Models\WebCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    public function catpage($category_id)
    {
        $category  = WebCategory::findOrFail($category_id);
        $webs = $category->webs()->where('category_id', $category_id)->get();
        $sortedCategory = $webs->sortBy('sort');
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.category.index', ['webs' => $sortedCategory, 'category' => $category , 'depart' => $depart]);
    }

    public function create($category_id)
    {
        $category  = WebCategory::findOrFail($category_id);
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.category.create', compact('category','depart'));
    }

    public function store(Request $request, $category_id)
    {
  
       
        $validator = Validator::make($request->all(), [
            'web_th' => 'required',
      
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }

        try{
        $lastSort = Web::where('category_id',$category_id)->max('sort');
        $newSort = $lastSort + 1;
        $webs = new Web;

     
    
        $webs->web_th = $request->web_th;
        $webs->web_en = $request->web_en;
        $webs->detail_th = $request->detail_th;
        $webs->detail_en = $request->detail_en;
        $webs->web_date = now();
        $webs->web_status = $request->input('web_status', 0);
        $webs->web_type = 0;
        $webs->recommended = $request->input('recommended', 0);
        $webs->sort = $newSort;;
        $webs->web_option =null;
        $webs->category_id = (int)$category_id;
        $webs->save();
        if ($request->hasFile('cover')) {
            $file_name = 'cover'.  $webs->web_id  . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Web/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Web/' . $file_name), file_get_contents($request->cover));
                $webs->cover = 'upload/Web/' . $file_name;
            }
        } else {
            $file_name = '';
            $webs->cover = $file_name;
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
    } catch (\Exception $e) {

        DB::rollBack();

        return response()->view('errors.500', [], 500);
    }
        return redirect()->route('catpage', ['category_id' => $category_id])->with('message', 'Data update successfully');
    }
    public function edit($web_id)
    {
        $webs = Web::findOrFail($web_id);
        $category_id = $webs->category_id;
        $category  = WebCategory::findOrFail($category_id);
        $department_id   = $category->department_id;
        $depart = Department::findOrFail($department_id);
     
        return view('page.manages.even.category.edit', compact('webs', 'category','depart'));
    }
    public function update(Request $request, $web_id)
    {
        $request->validate([
            'web_th' => 'required'

        ]);
        $webs = Web::findOrFail($web_id);
        if ($request->hasFile('cover')) {
            $file_name = 'cover'.  $web_id  . '.' . $request->cover->getClientOriginalExtension();
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
        $webs->detail_th = $request->detail_th;
        $webs->detail_en = $request->detail_en;
        $webs->web_update = now();
        $webs->web_status = $request->input('web_status', 0);
        $webs->recommended = $request->input('recommended', 0);

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

        return redirect()->route('catpage', ['category_id' => $webs->category_id])->with('warning', 'Data update successfully');
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
