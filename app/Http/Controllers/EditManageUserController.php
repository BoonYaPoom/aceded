<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Districts;
use App\Models\Provinces;
use App\Models\School;
use App\Models\Subdistricts;
use App\Models\UserRole;
use App\Models\Users;
use Illuminate\Support\Facades\Cache;

use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EditManageUserController extends Controller
{

    public function UserManage(Request $request, $user_role = null)
    {
        $usermanages = Cache::remember('usermanages', 60, function () use ($user_role) {
            $query = Users::query();

            if ($user_role !== null) {
                $query->where('user_role', $user_role);
            }
            return $query->get();
        });

        return view('page.UserAdmin.indexview', compact('usermanages'));
    }


    public function UserManagejson(Request $request, $user_role = null)
    {
        $usermanages = Users::query();
        $userAll = [];
        if ($user_role !== null) {
            $usermanages->where('user_role', $user_role);
        }

        $usermanages = $usermanages->get();

        $i = 1;
        foreach ($usermanages->sortBy('user_id') as  $item) {
            $name_short_en = Department::where('department_id', $item->department_id)
                ->pluck('name_en')
                ->first();
            $proviUser = Provinces::where('id', $item->province_id)
                ->pluck('name_in_thai')
                ->first();
            $id = $item->user_id;
            $username = $item->username;

            $email = $item->email;
            $status = $item->userstatus;
            $mobile = $item->mobile;

            $user_role = $item->user_role;
            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $fullname =  $firstname . ' ' . $lastname;
            $part1 = substr($mobile, 0, 3);
            $part2 = substr($mobile, 3, 3);
            $part3 = substr($mobile, 6, 4);
            $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
            $datauser[] = [

                'i' => $i++,
                'id' => $id,
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => $email,
                'status' => $status,
                'mobile' => $fullMobile,
                'proviUser' => $proviUser,
                'department' => $name_short_en,
                'user_role' => $user_role,
            ];

        }

        return response()->json(['datauser' => $datauser]);
    }



    public function edit($user_id)
    {
        $usermanages = Users::findOrFail($user_id);

        return view('page.UserAdmin.edit', ['usermanages' => $usermanages]);
    }


    public function update(Request $request, $user_id)
    {

        $usermanages = Users::findOrFail($user_id);


        if (!empty($request->hasFile('avatar'))) {
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
        $usermanages->birthday = $request->birthday;
        $usermanages->user_affiliation = $request->user_affiliation;
        $usermanages->province_id = $request->province_id;
        $usermanages->department_id = $request->department_id;

        $usermanages->user_type = $request->input('user_type', 0);
        $usermanages->mobile = $request->mobile;

        $usermanages->pos_name = $request->pos_name;


        // บันทึกการเปลี่ยนแปลง
        $usermanages->save();



        $department_data = $request->department_data;
        if (!empty($department_data)) {
            DB::table('users_department')
                ->where('user_id', $user_id)
                ->delete();


            foreach ($department_data as $departmentId) {
                DB::table('users_department')->insert([
                    'user_id' =>  $user_id,
                    'department_id' => $departmentId,
                ]);
            }
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

        return redirect()->back()->with('message', 'บันทึกข้อมูลสำเร็จ');
    }
    public function updatepassword(Request $request, $user_id)
    {


        // อัปเดตค่า user_role ในฐานข้อมูล
        $usermanages = Users::findOrFail($user_id);

        $usermanages->password = Hash::make($request->usearch);
        $usermanages->save();

        return redirect()->back()->with('message', 'บันทึกข้อมูลสำเร็จ');
    }

    public function createUser()
    {
        $role = UserRole::all();
        return view('page.UserAdmin.add.add_umsform', compact('role'));
    }


    public function changeStatus($user_id)
    {

        $usermanages = Users::find($user_id);

        // ตรวจสอบว่าหน้ามีค่า page_status ที่เป็น 1 หรือ 0
        if ($usermanages) {
            $newuserstatus = $usermanages->userstatus == 1 ? 0 : 1;
            $usermanages->userstatus = $newuserstatus;
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
        $usermanages->birthday = $request->birthday;
        $usermanages->user_affiliation = $request->user_affiliation;
        $usermanages->user_type = $request->input('user_type', 0);
        $usermanages->province_id = $request->province_id;
        $usermanages->user_type_card =  $request->input('user_type_card', 0);


        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;

        $usermanages->save();


        if (!empty($request->school)) {
            $existingSchool = School::where('school_name', $request->school)
                ->where('provinces_code', $request->province_id)
                ->where('subdistrict_code', null)
                ->where('district_code', null)
                ->first();

            if (!$existingSchool) {
                $scho = new School;

                $scho->school_name = $request->school;
                $scho->provinces_code = $request->province_id;
                $scho->subdistrict_code = null;
                $scho->district_code = null;

                $scho->save();

                $scho->school_code = $scho->school_id;
                $scho->save();
            } else {
                $scho = $existingSchool;
                if (empty($scho->school_code)) {
                    $scho->school_code = $scho->school_id;
                    $scho->save();
                }
            }
            $userschool = new UserSchool;
            $userschool->school_code = $scho->school_code;
            $userschool->user_id = $usermanages->user_id;
            $userschool->save();
        }
        $department_data = $request->department_data;
        foreach ($department_data as $departmentId) {
            DB::table('users_department')->insert([
                'user_id' =>    $usermanages->user_id,
                'department_id' => $departmentId,
            ]);
        }



        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    public function delete($user_id)
    {
        $usermanages = Users::findOrFail($user_id);
        $usermanages->delete();


        return redirect()->back()->with('message', 'usermanages ลบข้อมูลสำเร็จ');
    }
}
