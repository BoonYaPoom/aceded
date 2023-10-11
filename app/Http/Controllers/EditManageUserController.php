<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Districts;
use App\Models\School;
use App\Models\Subdistricts;
use App\Models\UserRole;
use App\Models\Users;

use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EditManageUserController extends Controller
{

    public function UserManage(Request $request, $user_role = null)
    {
        $usermanages = Users::query();

        if ($user_role !== null) {
            $usermanages->where('user_role', $user_role);
        }

        $usermanages = $usermanages->get();

        return view('page.UserAdmin.indexview', compact('usermanages'));
    }





    public function edit($user_id)
    {
        $usermanages = Users::findOrFail($user_id);
        return view('page.UserAdmin.edit', ['usermanages' => $usermanages]);
    }


    public function update(Request $request, $user_id)
    {

        $usermanages = Users::findOrFail($user_id);

        if ($request->hasFile('avatar')) {
            $image_name = 'avatar' .  $user_id . '.' . $request->avatar->getClientOriginalExtension();
            $image = Image::make($request->avatar)->resize(400, 400);
            $uploadDirectory = public_path('upload/Profile/' . $image_name);

            if (!file_exists(dirname($uploadDirectory))) {
                mkdir(dirname($uploadDirectory), 0755, true);
            }

            $image->save($uploadDirectory);
            $usermanages->avatar = 'upload/Profile/' . 'avatar' .  $user_id . '.' . $request->avatar->getClientOriginalExtension();
        }

        // ... อัปเดตฟิลด์อื่น ๆ ตามต้องการ
        $usermanages->username = $request->username;
        $usermanages->firstname = $request->firstname;
        $usermanages->lastname = $request->lastname;
        if ($request->password) {
            $usermanages->password = Hash::make($request->password);
        }


        $usermanages->citizen_id = $request->citizen_id;
        $usermanages->gender = $request->input('gender', 0);
        $usermanages->email = $request->email;

        $usermanages->modifieddate = now();

        $usermanages->province_id = $request->province_id;
        $usermanages->department_id = $request->department_id;

        $usermanages->user_type = $request->input('user_type', 0);
        $usermanages->mobile = $request->mobile;

        $usermanages->pos_name = $request->pos_name;
        if ($request->school) {
            // ค้นหาโรงเรียนโดยใช้ชื่อโรงเรียนจาก $request
            $existingSchool = School::where('school_name', $request->school)
                ->where('provinces_id', $request->province_id)
                ->where('subdistrict_id', null)
                ->where('district_id', null)
                ->first();

            // ถ้าไม่พบโรงเรียนในระบบใหม่
            if (!$existingSchool) {
                $scho = new School;
                $scho->school_name = $request->school;
                $scho->provinces_id = $request->province_id;
                $scho->subdistrict_id = null;
                $scho->district_id = null;
                $scho->save();
            } else {
                // ถ้าพบโรงเรียนในระบบแล้วให้ใช้ id ของโรงเรียนที่มีอยู่
                $scho = $existingSchool;
            }
        }

        // บันทึกการเปลี่ยนแปลง
        $usermanages->save();
        // ค้นหารายการ UserSchool ที่มี user_id และ school_id ที่ตรงกับข้อมูลที่คุณต้องการผูก
        $existingUserSchool = UserSchool::where('user_id', $usermanages->user_id)
            ->where('school_id', $scho->school_id)
            ->first();

        if (!$existingUserSchool) {
            // ถ้าไม่พบ UserSchool ในระบบใหม่
            $userschool = new UserSchool;
            $userschool->school_id = $scho->school_id;
            $userschool->user_id = $usermanages->user_id;
            $userschool->save();
        } else {
            $existingUserSchool->update([
                'school_id' => $scho->school_id,
                'user_id' => $usermanages->user_id,
            ]);
        }

        // ส่งข้อความสำเร็จไปยังหน้าแก้ไขโปรไฟล์
        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }



    public function updateRoleUser(Request $request, $user_id)
    {
        $user_roleValue = $request->input('user_role');

        // อัปเดตค่า user_role ในฐานข้อมูล
        $usermanages = Users::findOrFail($user_id);
        $usermanages->user_role = $user_roleValue;
        $usermanages->save();

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }
    public function updatepassword(Request $request, $user_id)
    {


        // อัปเดตค่า user_role ในฐานข้อมูล
        $usermanages = Users::findOrFail($user_id);

        $usermanages->password = Hash::make($request->usearch);
        $usermanages->save();

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function createUser()
    {
        $role = UserRole::all();
        return view('page.UserAdmin.add.add_umsform', compact('role'));
    }


    public function changeStatus(Request $request)
    {
        $usermanages = Users::find($request->user_id);

        if ($usermanages) {
            $usermanages->userstatus = $request->userstatus;
            $usermanages->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล usermanages']);
        }
    }

    public function autoschool(Request $request)
    {

        $data = School::select("school_name as value", "school_id")
            ->where('school_name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();

        return response()->json($data);
    }

    // ใน Controller
    public function showByuser_role(Request $request, $user_role)
    {
        if ($user_role === '0') {
            $usermanages = Users::all();
        } else {
            $usermanages = Users::where('user_role', $user_role)->get();
        }

        return view('page.UserAdmin.indexview', compact('usermanages'));
    }


    public function storeUser(Request $request)
    {
        $request->validate([

            'username' => 'required|unique:users',
            'firstname' => 'required',
            'password' => 'required|min:3|max:20',
            'citizen_id' => 'required|min:13|max:13',
            'email' => 'required|email|unique:users',
            'gender' => 'required',
            'mobile' => 'required',
            'user_type' => 'required',
            'pos_name' => 'required',
            'user_role' => 'required',


        ]);

        $usermanages = new Users();
        $usermanages->username = $request->username;
        $usermanages->firstname = $request->firstname;
        $usermanages->lastname = $request->lastname;
        $usermanages->password = Hash::make($request->password);
        $usermanages->citizen_id = $request->citizen_id;
        $usermanages->prefix  = '';
        $usermanages->gender = $request->input('gender', 0);
        $usermanages->email = $request->email;
        $usermanages->user_role =  $request->user_role;
        $usermanages->per_id = null;
        $usermanages->department_id = $request->department_id;

        $usermanages->permission = null;
        $usermanages->ldap = 0;
        $usermanages->userstatus = 1;
        $usermanages->createdate = now();
        $usermanages->createby = 2;
        $usermanages->avatar = '';
        $usermanages->user_position = '';
        $usermanages->workplace = $request->workplace;
        $usermanages->telephone = '';
        $usermanages->mobile = $request->mobile;
        $usermanages->socialnetwork = '';
        $usermanages->experience = null;
        $usermanages->recommened = null;
        $usermanages->templete = null;
        $usermanages->nickname = '';
        $usermanages->introduce = '';
        $usermanages->bgcustom = '';
        $usermanages->pay = '';
        $usermanages->education = '';
        $usermanages->teach = '';
        $usermanages->modern = '';
        $usermanages->other = '';
        $usermanages->profiles = null;
        $usermanages->editflag = null;
        $usermanages->pos_level = 0;
        $usermanages->pos_name = $request->pos_name;
        $usermanages->sector_id = 0;
        $usermanages->office_id = 0;

        $usermanages->user_type = $request->input('user_type', 0);
        $usermanages->province_id = $request->province_id;
        if ($request->school) {
            // ค้นหาโรงเรียนโดยใช้ชื่อโรงเรียนจาก $request
            $existingSchool = School::where('school_name', $request->school)
                ->where('provinces_id', $request->province_id)
                ->where('subdistrict_id', null)
                ->where('district_id', null)
                ->first();

            // ถ้าไม่พบโรงเรียนในระบบใหม่
            if (!$existingSchool) {
                $scho = new School;
                $scho->school_name = $request->school;
                $scho->provinces_id = $request->province_id;
                $scho->subdistrict_id = null;
                $scho->district_id = null;
                $scho->save();
            } else {
                // ถ้าพบโรงเรียนในระบบแล้วให้ใช้ id ของโรงเรียนที่มีอยู่
                $scho = $existingSchool;
            }
        }

        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;

        $usermanages->save();


        $userschool = new UserSchool;
        $userschool->school_id = $scho->school_id;
        $userschool->user_id = $usermanages->user_id;
        $userschool->save();

        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    public function delete($user_id)
    {
        $usermanages = Users::findOrFail($user_id);
        $usermanages->delete();


        return redirect()->back()->with('message', 'usermanages ลบข้อมูลสำเร็จ');
    }
}
