<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

use App\Models\Links;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    public function linkpage($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $links  = $depart->LinksDe()->where('department_id', $department_id)->get();
        $sortedLinks = $links->sortBy('sort');
        return view('page.manages.links.links', ['links' => $sortedLinks, 'depart' => $depart]);
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('page.manages.links.create',compact('depart'));
    }

    public function store(Request $request,$department_id)
    {
     
        $validator = Validator::make($request->all(), [
            'links_title' => 'required',
            'links' => 'required'

        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        $links = new Links;
        if ($request->hasFile('cover')) {
            $filename = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('links/' . $filename, file_get_contents($request->cover));
        } else {
            $filename = '';
        }
        $links->cover = $filename;
        $links->links_title = $request->links_title;
        $links->links_title = $request->links_title;
        $links->links = $request->links;
        $links->links_date  = now();
        $links->department_id  = (int)$department_id;
        $links->links_status = $request->input('links_status', 0);
        $links->sort  = Links::max('sort') + 1;
        $links->save();



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

        return redirect()->route('linkpage', ['department_id' => $department_id])->with('message', 'links บันทึกข้อมูลสำเร็จ');
    }
    public function edit($links_id)
    {
        $links = Links::findOrFail($links_id);
        $department_id   = $links->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manages.links.edit', ['links' => $links ,'depart' => $depart]);
    }

    public function update(Request $request, $links_id)
    {
        $request->validate([
            'links_title' => 'required',
            'links' => 'required'

        ]);
        $links = Links::findOrFail($links_id);
        if ($request->hasFile('cover')) {
            if (Storage::disk('external')->exists('links/' . $links->cover)) {
                // ลบไฟล์เดิมออกจาก Storage 'external'
                Storage::disk('external')->delete('links/' . $links->cover);
            }

            $filename = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('links/' . $filename, file_get_contents($request->cover));

            $links->cover = $filename;
        }
        $links->links_title = $request->links_title;
        $links->links_title = $request->links_title;
        $links->links = $request->links;
        $links->links_update  = now();

        $links->save();

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


        return redirect()->route('linkpage', ['department_id' => $links->department_id])->with('message', 'links บันทึกข้อมูลสำเร็จ');
    }

    public function destory($links_id)
    {
        $links = Links::findOrFail($links_id);
        $image_path = public_path() . "/images/";
        $image = $image_path . $links->cover;
        if (file_exists($image)) {
            @unlink($image);
        }
        $links->delete();
        return redirect()->back()->with('message', 'links ลบข้อมูลสำเร็จ');
    }


    // ...

    public function changeStatus(Request $request)
    {
        $links = Links::find($request->links_id);

        if ($links) {
            $links->links_status = $request->links_status;
            $links->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล links']);
        }
    }

    public function changeSortIink(Request $request)
    {
        $links = Links::find($request->links_id);

        if ($links) {
            $links->sort = $request->sort;
            $links->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล links']);
        }
    }
}
