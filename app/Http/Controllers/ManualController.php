<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManualController extends Controller
{
    public function index($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $manuals  = $depart->ManualsDe()->where('department_id', $department_id)->get();

        return view('page.manages.manual.index', compact('manuals','depart'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);
        
        return view('page.manages.manual.create',compact('depart'));
    }
    public function store(Request $request,$department_id)
    {

        
        $validator = Validator::make($request->all(), [
            'manual' => 'required',
            'manual_path' => 'required'

        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        $manuals = new Manual;
        $manuals->manual = $request->manual;
        if ($request->hasFile('cover')) {

            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Manual/image/' . $image_name, file_get_contents($request->cover));
        } else {
            $image_name = '';
        }
        $file_name = time() . '.' . $request->manual_path->getClientOriginalExtension();
        Storage::disk('external')->put('Manual/documents/' . $file_name, file_get_contents($request->manual_path));

        $manuals->cover = $image_name;
        $manuals->manual_path = $file_name;
        $manuals->detail = '';
        $manuals->department_id = (int)$department_id;
        $manuals->manual_status = 0;

        $manuals->manual_type = 1;
        $manuals->save();



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


            $loginLog = new Log();
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


        return redirect()->route('manualpage',['department_id' =>$department_id])->with('message', 'manuals บันทึกข้อมูลสำเร็จ');
    }
    public function edit($manual_id)
    {
        $manuals = Manual::findOrFail($manual_id);
        $department_id   = $manuals->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.manual.edit', compact('manuals','depart'));
    }
    public function update(Request $request, $manual_id)
    {

        $manuals = Manual::findOrFail($manual_id);
        $manuals->manual = $request->manual;
        if ($request->hasFile('cover')) {
       
            if (Storage::disk('external')->exists('Manual/documents/' . $manuals->cover)) {
                Storage::disk('external')->delete('Manual/documents/' . $manuals->cover); // ลบไฟล์เดิม
            }
            
            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Manual/image/' . $image_name, file_get_contents($request->cover));
            $manuals->cover = $image_name;
        }
        if ($request->hasFile('manual_path')) {
            if (Storage::disk('external')->exists('Manual/documents/' . $manuals->manual_path)) {
                Storage::disk('external')->delete('Manual/documents/' . $manuals->manual_path); // ลบไฟล์เดิม
            }
            $file_name = time() . '.' . $request->manual_path->getClientOriginalExtension();
            Storage::disk('external')->put('Manual/documents/' . $file_name, file_get_contents($request->manual_path));
            $manuals->manual_path = $file_name;
        }
   
   
        $manuals->detail = '';
        $manuals->manual_status = 0;
        $manuals->manual_type = '';
        $manuals->save();



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


            $loginLog = new Log();
            $loginLog->logid = 3;
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


        return redirect()->route('manualpage',['department_id' =>$manuals->department_id])->with('message', 'manuals บันทึกข้อมูลสำเร็จ');
    }


    public function destory($manual_id)
    {
        $manuals = Manual::findOrFail($manual_id);
        Storage::disk('external')->delete('Manual/documents/' . $manuals->cover); // ลบไฟล์เดิม
        Storage::disk('external')->delete('Manual/documents/' . $manuals->manual_path); // ลบไฟล์เดิม
        $manuals->delete();


        return redirect()->back()->with('message', 'manuals ลบข้อมูลสำเร็จ');
    }

    public function changeStatus(Request $request)
    {
        $manuals = Manual::find($request->manual_id);

        if ($manuals) {
            $manuals->manual_status = $request->manual_status;
            $manuals->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล links']);
        }
    }
}
