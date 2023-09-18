<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\WebCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WedCategoryController extends Controller
{
    public function Webpage($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manages.even.index', compact('depart'));
    }
    public function evenpage($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $wed  = $depart->webcatDe()->where('department_id', $department_id)->get();
        return view('page.manages.even.page.even.evens', compact('wed', 'depart'));
    }
    public function acteven($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $wed  = $depart->webcatDe()->where('department_id', $department_id)->get();
        return view('page.manages.even.page.act.Acteven', compact('wed', 'depart'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.page.even.create', compact('depart'));
    }
    public function createact($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.page.act.createact', compact('depart'));
    }
    public function store(Request $request, $department_id)
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
        $wed = new WebCategory;
       

     
        $wed->category_th = $request->category_th;
        $wed->category_en = $request->category_en;
        $wed->startdate = null;
        $wed->enddate = null;
        $wed->detail_th = '';
        $wed->detail_en = '';
        $wed->category_date = now();
        $wed->category_update = null;
        $wed->category_status = $request->input('category_status', 0);
        $wed->category_type = 1;
        $wed->category_option = null;
        $wed->department_id = (int)$department_id;
        $wed->recommended = 1;
        $wed->save();


        if ($request->hasFile('cover')) {
            $file_name = 'cover' . $wed->category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/webcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/webcategory/' . $file_name), file_get_contents($request->cover));
                $wed->cover = 'upload/webcategory/' . $file_name;
            }
        } else {
            $file_name = '';
            $wed->cover = $file_name;
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
            $loginLog = Log::where('uid', $loginId)->where('logaction', 2)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 2;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();


        return redirect()->route('evenpage', ['department_id' => $department_id])->with('message', 'Data saved successfully');
    }
    public function storeact(Request $request, $department_id)
    {
        $request->validate([
            'category_th' => 'required'

        ]);
        $wed = new WebCategory;
      
      
        $wed->category_th = $request->category_th;
        $wed->category_en = $request->category_en;
        $wed->detail_th = '';
        $wed->detail_en = '';
        $wed->category_date = now();
        $wed->startdate = $request->startdate;
        $wed->enddate = $request->enddate;
        $wed->category_status = $request->input('category_status', 0);
        $wed->category_type = 2;
        $wed->category_option = null;
        $wed->department_id = (int)$department_id;
        $wed->recommended = 1;
        $wed->save();

        if ($request->hasFile('cover')) {
            $file_name = 'cover' . $wed->category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/webcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/webcategory/' . $file_name), file_get_contents($request->cover));
                $wed->cover = 'upload/webcategory/' . $file_name;
            }
        } else {
            $file_name = '';
            $wed->cover = $file_name;
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
            $loginLog = Log::where('uid', $loginId)->where('logaction', 2)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 2;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();


        return redirect()->route('acteven', ['department_id' => $department_id])->with('message', 'Data saved successfully');
    }
    public function edit($category_id)
    {
        $wed = WebCategory::findOrFail($category_id);
        $department_id   = $wed->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.page.even.edit', ['wed' => $wed, 'depart' => $depart]);
    }
    public function editact($category_id)
    {
        $wed = WebCategory::findOrFail($category_id);
        $department_id   = $wed->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.even.page.act.editact', ['wed' => $wed, 'depart' => $depart]);
    }

    public function update(Request $request, $category_id)
    {

        $wed = WebCategory::findOrFail($category_id);
        if ($request->hasFile('cover')) {
            $file_name = 'cover' . $category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/webcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/webcategory/' . $file_name), file_get_contents($request->cover));
                $wed->cover = 'upload/webcategory/' . $file_name;
            }
        } 
    


        $wed->category_th = $request->category_th;
        $wed->category_en = $request->category_en;

        $wed->category_update = now();

        $wed->save();

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
            $loginLog = Log::where('uid', $loginId)->where('logaction', 3)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 3;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();

        return redirect()->route('evenpage', ['department_id' => $wed->department_id])->with('warning', 'Data update successfully');
    }
    public function updateact(Request $request, $category_id)
    {

        $wed = WebCategory::findOrFail($category_id);

        if ($request->hasFile('cover')) {
            $file_name = 'cover' . $category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/webcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/webcategory/' . $file_name), file_get_contents($request->cover));
                $wed->cover = 'upload/webcategory/' . $file_name;
            }
        } 

        $wed->category_th = $request->category_th;
        $wed->category_en = $request->category_en;
        $wed->startdate = $request->startdate;
        $wed->enddate = $request->enddate;
        $wed->category_update = now();

        $wed->save();

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
            $loginLog = Log::where('uid', $loginId)->where('logaction', 3)->first();


            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 3;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
        }


        $loginLog->save();

        return redirect()->route('acteven', ['department_id' => $wed->department_id])->with('warning', 'Data update successfully');
    }

    public function destroy($category_id)
    {
        $wed = WebCategory::findOrFail($category_id);

        $wed->delete();



        return redirect()->back()->with('message', 'Data destroy successfully');
    }
    public function changeStatus(Request $request)
    {
        $wed = WebCategory::find($request->category_id);

        if ($wed) {
            $wed->category_status = $request->category_status;
            $wed->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล wed']);
        }
    }
}
