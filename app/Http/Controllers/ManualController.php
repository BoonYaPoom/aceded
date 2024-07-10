<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManualController extends Controller
{
    public function index($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $manuals  = $depart->ManualsDe()->where('department_id', $department_id)->get();

        return view('page.manages.manual.index', compact('manuals', 'depart'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manages.manual.create', compact('depart'));
    }
    public function store(Request $request, $department_id)
    {
        DB::commit();

    
        try {
            $manuals = new Manual;

            $manuals->manual = $request->manual;
            if ($request->hasFile('manual_path')) {
                $filename = time()  . '.' . $request->manual_path->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Manual/documents/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/Manual/documents/' . $filename), file_get_contents($request->manual_path));
                //     $manuals->manual_path = 'upload/Manual/documents/' .   $filename;
                // }
                $uploadDirectory = 'Manual/documents/';
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->manual_path->getRealPath()));
                    $manuals->manual_path = 'upload/Manual/documents/' . $filename;
                }
            }

            $manuals->detail = '';
            $manuals->department_id = (int)$department_id;
            $manuals->manual_status = $request->input('manual_status', 0);
            $manuals->manual_type = 1;
            $manuals->save();
            if ($request->hasFile('cover')) {
                $image_name = 'cover' .  $manuals->manual_id . '.' . $request->cover->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Manual/image/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {
    
                //     file_put_contents(public_path('upload/Manual/image/' . $image_name), file_get_contents($request->cover));
                //     $manuals->cover = 'upload/Manual/image/' .   $image_name;
                // }
                $uploadDirectory = 'Manual/image/';
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->cover->getRealPath()));
                    $manuals->cover = 'upload/Manual/image/' . $image_name;
                }
                $manuals->save();
            } else {
                $image_name = '';
                $manuals->cover = $image_name;
                $manuals->save();
            }
    
            DB::commit();
        } catch (\Exception $e) {
    
            DB::rollBack();
            
            return response()->view('error.error-500', [], 500);
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


            $loginLog = new Log();
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


        return redirect()->route('manualpage', ['department_id' => $department_id])->with('message', 'manuals บันทึกข้อมูลสำเร็จ');
    }
    public function edit($department_id,$manual_id)
    {
        $manuals = Manual::findOrFail($manual_id);
        $department_id   = $manuals->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.manual.edit', compact('manuals', 'depart'));
    }
    public function update(Request $request,$department_id, $manual_id)
    {

        $manuals = Manual::findOrFail($manual_id);
        $manuals->manual = $request->manual;
        if ($request->hasFile('cover')) {
            $image_name = 'cover' .  $manual_id . '.' . $request->cover->getClientOriginalExtension();
            // $uploadDirectory = public_path('upload/Manual/image/');
            // if (!file_exists($uploadDirectory)) {
            //     mkdir($uploadDirectory, 0755, true);
            // }
            // if (file_exists($uploadDirectory)) {

            //     file_put_contents(public_path('upload/Manual/image/' . $image_name), file_get_contents($request->cover));
            //     $manuals->cover = 'upload/Manual/image/' .   $image_name;
            // }
            $uploadDirectory = 'Manual/image/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->delete($uploadDirectory);
                Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->cover->getRealPath()));
                $manuals->cover = 'upload/Manual/image/' . $image_name;
            }
        } 

        if ($request->hasFile('manual_path')) {
            $filename = 'manual_path' .  $manual_id . '.' . $request->manual_path->getClientOriginalExtension();
            // $uploadDirectory = public_path('upload/Manual/documents/');
            // if (!file_exists($uploadDirectory)) {
            //     mkdir($uploadDirectory, 0755, true);
            // }
            // if (file_exists($uploadDirectory)) {

            //     file_put_contents(public_path('upload/Manual/documents/' . $filename), file_get_contents($request->manual_path));
            // }
            $uploadDirectory = 'Manual/documents/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->delete($uploadDirectory);
                Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->manual_path->getRealPath()));
                $manuals->manual_path = 'upload/Manual/documents/' . $filename;
            }
        }
        $manuals->detail = '';
        $manuals->manual_status = 0;
        $manuals->manual_status = $request->input('manual_status', 0);
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
            $loginLog = Log::where('user_id', $loginId)->where('logaction', 2)->first();


            $loginLog = new Log();
            $loginLog->logid = 3;
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


        return redirect()->route('manualpage', ['department_id' => $manuals->department_id])->with('message', 'manuals บันทึกข้อมูลสำเร็จ');
    }


    public function destory($manual_id)
    {
        $manuals = Manual::findOrFail($manual_id);

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
