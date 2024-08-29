<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\General;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use LdapRecord\Models\Attributes\Timestamp;

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
            // $uploadDirectory = public_path('upload/LOGO/');
            // if (!file_exists($uploadDirectory)) {
            //     mkdir($uploadDirectory, 0755, true);
            // }
            // if (file_exists($uploadDirectory)) {

            //     file_put_contents(public_path('upload/LOGO/' . $filename), file_get_contents($request->detail));
            //     $genaral->detail = 'upload/LOGO/' . 'logo' . '.' . $request->detail->getClientOriginalExtension();
            // }
            // อัปเดตข้อมูลในตาราง 'General'
            $uploadDirectory = 'LOGO/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->detail->getRealPath()));
            }
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

            $filename = 'logo' .  $department_id . '.' . $request->detail->getClientOriginalExtension();
            // $uploadDirectory = public_path('upload/LOGO/' .  $department_id . '/');
            // if (!file_exists($uploadDirectory)) {
            //     mkdir($uploadDirectory, 0755, true);
            // }
            // if (file_exists($uploadDirectory)) {

            //     file_put_contents(public_path('upload/LOGO/' . $department_id . '/'  . $filename), file_get_contents($request->detail));
            //     $genaral->detail = 'upload/LOGO/' .   $department_id . '/'  . $filename;
            // }
            // อัปเดตข้อมูลในตาราง 'General'
            $uploadDirectory = 'LOGO/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->put($uploadDirectory . '/'  . $department_id . '/'  . $filename, file_get_contents($request->detail->getRealPath()));
                $genaral->detail = 'upload/LOGO/' .   $department_id . '/'  . $filename;
            }
            $genaral->title = 'logo';
        }

        $genaral->save();
        return redirect()->back()->with('message', 'logo บันทึกข้อมูลสำเร็จ');
    }

    public function CreatePopup(Request $request)
    {
        $request->validate([
            'detail' => 'required'
        ]);
        $genaral = new General;
        $genaral->startdate = $request->startdate;
        $genaral->enddate =  $request->enddate;
        $genaral->title = 'popup';
        $genaral->status = 0;
        $genaral->createdate = now();
        $genaral->modifieddate = now();
        $genaral->department_id = 0;

        $genaral->save();
        if ($request->hasFile('detail')) {
            $image = $request->file('detail');
            // $fileSize = $image->getSize(); // ขนาดไฟล์ในหน่วย bytes
            //  ดึงขนาดรูปภาพ (ความกว้างและความสูง)
            $imageSize = getimagesize($image);
            $width = $imageSize[0]; // ความกว้าง
            $height = $imageSize[1]; // ความสูง
            // สร้างอาร์เรย์ของข้อมูลความกว้างและความสูง
            $HW = [
                'width' => $width,
                'height' => $height
            ];

            // แปลงอาร์เรย์เป็น JSON
            $HWJson = json_encode($HW);
            $genaral->image_property = $HWJson;
            $filename = 'popup' . $genaral->id . '.' . $request->detail->getClientOriginalExtension();
            $uploadDirectory = 'popup/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->put($uploadDirectory   . $filename, file_get_contents($request->detail->getRealPath()));
                $genaral->detail = 'upload/'  . $uploadDirectory  . $filename;
            }
            $genaral->title = 'popup';
        }
        $genaral->detail = 'upload/'  . $uploadDirectory   . $filename;
        $genaral->save();

        return redirect()->back()->with('message', 'logo บันทึกข้อมูลสำเร็จ');
    }
    public function changeStatus(Request $request)
    {
        $Generals = General::find($request->id);

        if ($Generals) {
            $Generals->status = $request->status;
            $Generals->save();
            if ($request->status == 1) {
                $updatedIds = General::where('id', '!=', $request->id)
                    ->where('title', 'popup')
                    ->pluck('id')
                    ->toArray();

                General::whereIn('id', $updatedIds)
                    ->update(['status' => 0]);
            }

            return response()->json([
                'message' => 'Status updated successfully.',
                'updated_ids' => $updatedIds
            ]);
        } else {
            return response()->json(['message' => 'General not found.'], 404);
        }
    }
    public function destroy($id)
    {
        // ค้นหา General ตาม ID
        $general = General::findOrFail($id);
        // กำหนดพาธไฟล์ที่เก็บอยู่ใน detail
        $fullFilePath = $general->detail;
        // ตัด `upload/` ออกจากพาธไฟล์เพื่อให้ตรงกับไฟล์ที่เก็บไว้ใน SFTP
        $filePath = str_replace('upload/', '', $fullFilePath);
        // เช็คและลบไฟล์จาก SFTP
        if (Storage::disk('sftp')->exists($filePath)) {
            Storage::disk('sftp')->delete($filePath);
        }
        // ลบข้อมูลจากฐานข้อมูล
        $general->delete();
        // ส่งข้อความยืนยันการลบข้อมูล
        return redirect()->back()->with('message', 'ลบข้อมูลสำเร็จ');
    }
}
