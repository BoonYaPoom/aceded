<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\School;
use App\Models\UserRole;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class DepartUsersController extends Controller
{

    public function DPUserManage(Request $request, $department_id, $user_role = null)
    {
        $depart = Department::findOrFail($department_id);

        if (Session::has('loginId')) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $provicValue = $data->province_id;

            // ดึงผู้ใช้ที่มีค่า provic เท่ากันกับ $provicValue
            if ($data->user_role == 1) {
                // ถ้า data->role เป็น 1 แสดงผู้ใช้ทั้งหมด
                $usermanages = $depart->UserDe()->where('department_id', $department_id);
                if ($user_role !== null) {
                    $usermanages->where('user_role', $user_role);
                }

                $usermanages = $usermanages->get();
            } elseif($data->user_role == 7) {
                // ถ้า data->role เป็น 0 แสดงผู้ใช้ที่มีค่า province_id เท่ากับ $provicValue
                $usermanages = $depart->UserDe()->where('department_id', $department_id)
                    ->where('province_id', $provicValue);
                if ($user_role !== null) {
                    $usermanages->where('user_role', $user_role);
                }

                $usermanages = $usermanages->get();
            }
        } else {
            $usermanages = collect(); // ถ้า Session::get('loginId') ไม่มีค่า, กำหนด $usermanages เป็นคอลเลกชันว่าง
        }


        return view('layouts.department.item.data.UserAdmin.indexview', compact('usermanages', 'depart'));
    }


    public function DPeditUser($department_id, $user_id)
    {
        $usermanages = Users::findOrFail($user_id);

        $depart = Department::findOrFail($department_id);
        return view('layouts.department.item.data.UserAdmin.edit', ['usermanages' => $usermanages, 'depart' => $depart]);
    }

    public function DPupdateUser(Request $request, $department_id, $user_id)
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

        // บันทึกการเปลี่ยนแปลง
        $usermanages->save();

        // ส่งข้อความสำเร็จไปยังหน้าแก้ไขโปรไฟล์
        return redirect()->route('DPUserManage', ['department_id' => $usermanages->department_id])->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    public function createUser($department_id)
    {
        $depart = Department::findOrFail($department_id);

        $role = UserRole::all();
        return view('layouts.department.item.data.UserAdmin.add.add_umsform', compact('depart', 'role'));
    }

    public function storeUser(Request $request, $department_id)
    {
        $request->validate([

            'username' => 'required|unique:users',
            'firstname' => 'required',
            'password' => 'required|min:3|max:20',
            'citizen_id' => 'required|unique:users',
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
        $usermanages->department_id = $department_id;

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
        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;
        $usermanages->birthday = $request->birthday;
        $usermanages->user_affiliation = $request->user_affiliation;
        $usermanages->user_type_card =  $request->input('user_type_card', 0);

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

        $usermanages->save();

        $userschool = new UserSchool;
        $userschool->school_id = $scho->school_id;
        $userschool->user_id = $usermanages->user_id;
        $userschool->save();
        return redirect()->route('DPUserManage', ['department_id' => $department_id])->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    public function DPSchoolcreateUser($department_id, $school_id)
    {
        $depart = Department::findOrFail($department_id);
        $school = School::findOrFail($school_id);
        $role = UserRole::all();
        return view('layouts.department.item.data.UserAdmin.group.umsschool.item.add_umsform', compact('depart', 'role', 'school'));
    }



    public function DPSchoolstoreUser(Request $request, $department_id, $school_id)
    {
        $school = School::find($school_id);

        $request->validate([

            'username' => 'required|unique:users',
            'firstname' => 'required|unique:users',
            'password' => 'required|min:3|max:20',
            'citizen_id' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'gender' => 'required',
            'mobile' => 'required',
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
        $usermanages->user_role =  4;
        $usermanages->per_id = null;
        $usermanages->department_id = $department_id;
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
        $usermanages->pos_name = 'นักเรียน';
        $usermanages->sector_id = 0;
        $usermanages->office_id = 0;
        $usermanages->user_type = 2;

        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;
        $usermanages->birthday = $request->birthday;
        $usermanages->user_affiliation = 0;
        $usermanages->user_type_card =  $request->input('user_type_card', 0);
        $usermanages->save();

        $usermanages->province_id = $school->provinces_id;
        $usermanages->save();
        $userschool = new UserSchool;
        $userschool->school_id = $school_id;
        $userschool->user_id = $usermanages->user_id;
        $userschool->save();

        return redirect()->route('umsschooluserDepart', ['department_id' => $department_id, 'school_id' => $school_id])->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }
}
