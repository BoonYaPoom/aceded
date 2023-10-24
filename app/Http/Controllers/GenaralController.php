<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\General;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GenaralController extends Controller
{
    public function logo()
    {
        $genaral = General::all();
        return view('layouts.department.item.data.logo.logo', compact('genaral'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required'

        ]);
        $genaral = General::findOrFail($id);

        if ($request->hasFile('detail')) {

            $filename = 'logo' . '.' . $request->detail->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/LOGO/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/LOGO/' . $filename), file_get_contents($request->detail));
                $genaral->detail = 'upload/LOGO/' . 'logo' . '.' . $request->detail->getClientOriginalExtension();
            }
            // อัปเดตข้อมูลในตาราง 'General'

            $genaral->title = 'logo';
        }

        $genaral->save();


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
            $loginLog->logid = 3;
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

        return redirect()->route('logo')->with('message', 'logo บันทึกข้อมูลสำเร็จ');
    }

    public function logoDP($department_id)
    {
        $depart = Department::findOrFail($department_id);

        $genaral  = $depart->GenDe()->where('department_id', $department_id)->get();
        return view('page.manages.logo.logo', compact('genaral', 'depart'));
    }
    public function updateDP(Request $request, $department_id, $id)
    {
        $request->validate([
            'detail' => 'required'

        ]);
        $genaral = General::findOrFail($id);

        if ($request->hasFile('detail')) {

            $filename = 'logo' . '.' . $request->detail->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/LOGO/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/LOGO/' . $filename), file_get_contents($request->detail));
                $genaral->detail = 'upload/LOGO/' . 'logo' . '.' . $request->detail->getClientOriginalExtension();
            }
            // อัปเดตข้อมูลในตาราง 'General'

            $genaral->title = 'logo';
        }

        $genaral->save();
        return redirect()->back()->with('message', 'logo บันทึกข้อมูลสำเร็จ');
    }
}
