<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Highlight;
use App\Models\Log;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    public function hightpage()
    {
        $hights = Highlight::all();
        return view('layouts.department.item.data.imghead.imgheadedit', compact('hights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'highlight_path' => 'required'

        ]);
        try{
        $hights = new Highlight;

        $image_name = time() . '.' . $request->highlight_path->getClientOriginalExtension();
        $uploadDirectory = public_path('upload/Highlight/Main/');
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }
        if (file_exists($uploadDirectory)) {

            file_put_contents(public_path('upload/Highlight/Main/' . $image_name), file_get_contents($request->highlight_path));
            $hights->highlight_path = 'upload/Highlight/Main/' . $image_name;
        }

        $hights->department_id = 0;
        $hights->highlight_status = $request->input('links_status', 0);
        $hights->save();

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
        DB::commit();
    } catch (\Exception $e) {

        DB::rollBack();

        return response()->view('error.error-500', [], 500);
    }

        return redirect()->route('hightpage')->with('message', 'hightpage บันทึกข้อมูลสำเร็จ');
    }





    public function destory($highlight_id)
    {
        $hights = Highlight::findOrFail($highlight_id);
        $filePath = public_path($hights->highlight_path);

        if (file_exists($filePath)) {

            unlink($filePath);
        }

        $hights->delete();
        return redirect()->back()->with('message', 'hightpage ลบข้อมูลสำเร็จ');
    }
    public function updateLinkDep(Request $request, $highlight_id)
    {
        $hights = Highlight::findOrFail($highlight_id);
        $hights->highlight_link = $request->highlight_link;

        $hights->save();
        return redirect()->back()->with('message', 'hightpage ลบข้อมูลสำเร็จ');
    }
    public function changeStatus(Request $request)
    {
        $highlight = Highlight::find($request->highlight_id);

        if ($highlight) {
            $highlight->highlight_status = $request->highlight_status;
            $highlight->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Highlight']);
        }
    }

    public function hightDep($department_id)
    {

        $depart  = Department::findOrFail($department_id);
        $hights = $depart->hightlight()->where('department_id', $department_id)->get();
        return view('page.manages.imghead.imgheadedit', compact('hights', 'depart'));
    }

    public function storeDep(Request $request, $department_id)
    {
        $request->validate([
            'highlight_path' => 'required'

        ]);
        $hights = new Highlight;

      
        $image_name = time() . '.' . $request->highlight_path->getClientOriginalExtension();
        $uploadDirectory = public_path('upload/Highlight/Department/');
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }
        if (file_exists($uploadDirectory)) {

            file_put_contents(public_path('upload/Highlight/Department/' . $image_name), file_get_contents($request->highlight_path));
            $hights->highlight_path = 'upload/Highlight/Department/' . $image_name;
        }



        $hights->highlight_link = $request->highlight_link;
        $hights->highlight_status = $request->input('links_status', 0);
        $hights->department_id = (int)$department_id;
        $hights->save();

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


        return redirect()->route('hightDep', ['department_id' => $hights->department_id])->with('message', 'hightpage บันทึกข้อมูลสำเร็จ');
    }
}
