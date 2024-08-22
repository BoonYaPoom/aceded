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
        return view('page.manages.links.create', compact('depart'));
    }

    public function store(Request $request, $department_id)
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

        $lastSort = Links::where('department_id', $department_id)->max('sort');
        $newSort = $lastSort + 1;
        try {
            $links = new Links;


            $links->links_title = $request->links_title;
            $links->links_title = $request->links_title;
            $links->links = $request->links;
            $links->links_date  = now();
            $links->department_id  = (int)$department_id;
            $links->links_status = $request->input('links_status', 0);
            $links->sort  = $newSort;
            $links->save();

            if ($request->hasFile('cover')) {
                $filename = 'cover' . $links->link_id . '.' . $request->cover->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Links/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/Links/' . $filename), file_get_contents($request->cover));
                //     $links->cover = 'upload/Links/' .   'cover' . $links->link_id . '.' . $request->cover->getClientOriginalExtension();
                //     $links->save();
                // }
                $uploadDirectory = 'Links/';
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
     
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->cover->getRealPath()));
                    $links->cover = 'upload/Links/' .   'cover' . $links->link_id . '.' . $request->cover->getClientOriginalExtension();
                    $links->save();
                }
            } else {
                $filename = '';
                $links->cover = $filename;
                $links->save();
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
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
        return redirect()->route('linkpage', ['department_id' => $department_id])->with('message', 'links บันทึกข้อมูลสำเร็จ');
    }
    public function edit($department_id, $links_id)
    {
        $links = Links::findOrFail($links_id);

        $depart = Department::findOrFail($department_id);
        return view('page.manages.links.edit', ['links' => $links, 'depart' => $depart]);
    }

    public function update(Request $request, $department_id, $links_id)
    {
        $request->validate([
            'links_title' => 'required',
            'links' => 'required'

        ]);
        $links = Links::findOrFail($links_id);

        if ($request->hasFile('cover')) {
            $filename = 'cover' . $links_id . '.' . $request->cover->getClientOriginalExtension();
            // $uploadDirectory = public_path('upload/Links/');
            // if (!file_exists($uploadDirectory)) {
            //     mkdir($uploadDirectory, 0755, true);
            // }
            // if (file_exists($uploadDirectory)) {

            //     file_put_contents(public_path('upload/Links/' . $filename), file_get_contents($request->cover));
            //     $links->cover = 'upload/Links/' .   'cover' . $links_id . '.' . $request->cover->getClientOriginalExtension();

            // }
            $uploadDirectory = 'Links/' . $filename;
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->delete($uploadDirectory);
                Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->cover->getRealPath()));
                $links->cover = 'upload/Links/' .   'cover' . $links->link_id . '.' . $request->cover->getClientOriginalExtension();
                $links->save();
            }
        } 

        $links->links_title = $request->links_title;
        $links->links_title = $request->links_title;
        $links->links = $request->links;
        $links->links_update  = now();
        $links->links_status = $request->input('links_status', 0);
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
