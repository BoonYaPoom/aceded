<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class EditProfileController extends Controller
{
    public function edit()
    {
        // ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
        if (Session::has('loginId')) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $data = Users::where('uid', '=', Session::get('loginId'))->first();

            // ส่งข้อมูลผู้ใช้ไปยังหน้าแก้ไขโปรไฟล์
            return view('Authpage.Login.editprofile.edit', ['data' => $data]);
        }
     // หากไม่ได้เข้าสู่ระบบ ให้กลับไปยังหน้าเข้าสู่ระบบหรือหน้าหลักของคุณ
     return redirect()->route('login');
    }

    public function update(Request $request)
    {

        // ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
        if (Session::has('loginId')) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $users = Users::where('uid', '=', Session::get('loginId'))->first();
            
            if ($request->hasFile('avatar')) {
                // ลบรูปภาพเก่า (ถ้ามี)
                if ($users->avatar) {
                    $oldImagePath = public_path('profile') . '/' . $users->avatar;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            
                $image_name = time() . '.' . $request->avatar->getClientOriginalExtension();
                Storage::disk('external')->put('profile/' . $image_name, file_get_contents($request->avatar));
                $image = Image::make($request->avatar)->resize(400, 400);
                Storage::disk('external')->put('profile/' . $image_name, $image->stream());
                $users->avatar = $image_name;
            }
            
            // ... อัปเดตฟิลด์อื่น ๆ ตามต้องการ
            $users->username = $request->username;
            $users->firstname = $request->firstname;
            $users->lastname = $request->lastname;
            if ($request->password) {
                $users->password = Hash::make($request->password);
            }
            
            
            $users->citizen_id = $request->citizen_id;
            $users->gender = $request->input('gender', 0);
            $users->email = $request->email;

            $users->modifieddate = now();
    


            $users->user_type = $request->input('user_type', 0);
            $users->mobile = $request->mobile;
            
            $users->pos_name = $request->pos_name;
       
            // บันทึกการเปลี่ยนแปลง
            $users->save();

            // ส่งข้อความสำเร็จไปยังหน้าแก้ไขโปรไฟล์
            return redirect()->route('edit-profile')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
        }
  }
  }


