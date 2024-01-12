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
use Yajra\DataTables\Facades\DataTables;

class EditManageUserController extends Controller
{

    public function UserManage(Request $request, $user_role = null)
    {


        return view('page.UserAdmin.indexview');
    }


    public function UserManagejson1(Request $request, $user_role = null)
    {
        $usermanages = Users::query();
        $userAll = [];
        if ($user_role !== null) {
            $usermanages->where('user_role', $user_role);
        }

        $usermanages = $usermanages->get();

        $i = 1;
        foreach ($usermanages->sortBy('user_id') as  $item) {

            $proviUser = Provinces::where('id', $item->province_id)
                ->pluck('name_in_thai')
                ->first();
            $id = $item->user_id;
            $username = $item->username;
            $email = $item->email;
            $status = $item->userstatus;
            $user_role = $item->user_role;
            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $fullname =  $firstname . ' ' . $lastname;
            $mobile = $item->mobile;
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

                'user_role' => $user_role,
            ];
        }

        return response()->json(['datauser' => $datauser]);
    }
    public function UserManagejson(Request $request, $user_role = null)
    {
        $usermanages = Users::query();
        if ($user_role !== null) {
            $usermanages->where('user_role', $user_role);
        }

        $i = 1;
        $perPage = $request->input('length', 10);
        $currentPage = $request->input('start', 0) / $perPage + 1;


        return DataTables::eloquent($usermanages)
            ->addColumn('num', function () use (&$i, $currentPage, $perPage) {
                return $i++ + ($currentPage - 1) * $perPage;
            })
            ->addColumn('id', function ($userdata) {
                return $userdata->user_id;
            })
            ->addColumn('username', function ($userdata) {
                return $userdata->username;
            })

            ->addColumn('fullname', function ($userdata) {

                return  $userdata->firstname . ' ' . $userdata->lastname;
            })

            ->addColumn('email', function ($userdata) {
                return $userdata->email;
            })

            ->addColumn('fullMobile', function ($userdata) {
                $mobile = $userdata->mobile;
                $part1 = substr($mobile, 0, 3);
                $part2 = substr($mobile, 3, 3);
                $part3 = substr($mobile, 6, 4);
                $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
                return $fullMobile;
            })

            ->addColumn('status', function ($userdata) {
                return $userdata->userstatus;
            })

            ->addColumn('name_in_thai', function ($userdata) {
                $name_in_thai = Provinces::where('code', $userdata->province_id)
                    ->pluck('name_in_thai')
                    ->first();

                return $name_in_thai;
            })
            ->addColumn('user_role', function ($userdata) {
                return $userdata->user_role;
            })

            ->filter(function ($userdata) use ($request) {

                if ($request->has('myInput') && !empty($request->myInput)) {
                    $userdata->where('firstname', 'like', '%' . $request->myInput . '%')->orWhere('lastname', 'like', '%' . $request->myInput . '%');
                }
            })
            ->filterColumn('name_in_thai', function ($userdata) use ($request) {

                if ($request->drop2 != '0') {
                    $userdata->where('province_id', $request->drop2);
                }
            })

            ->make(true);
    }


    public function edit($user_id)
    {
        $usermanages = Users::findOrFail($user_id);
        $role = UserRole::all();
        $extender_1 = DB::table('users_extender')->where('department', 6)->where('department_lv', 0)->where('status', 1)->get();
        $extender_2 = DB::table('users_extender')->where('department', 6)->where('department_lv', 1)->where('status', 1)->get();
        $extender_3 = DB::table('users_extender')->where('department', 6)->where('department_lv', 2)->where('status', 1)->get();
        $extender1 = DB::table('users_extender2')->where('item_lv', 1)->get();
        $extender2 = DB::table('users_extender2')->where('item_lv', 2)->get();
        $extender3 = DB::table('users_extender2')->where('item_lv', 3)->get();
        $extender4 = DB::table('users_extender2')->where('item_lv', 4)->get();
        $extender5 = DB::table('users_extender2')->where('item_lv', 5)->get();
        return view('page.UserAdmin.edit', compact('usermanages', 'role', 'extender1', 'extender2', 'extender3', 'extender4', 'extender5', 'extender_1', 'extender_2', 'extender_3'));
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
            $usermanages->avatar = 'https://aced-bn.nacc.go.th/' . 'upload/Profile/' . 'avatar' .  $user_id . '.' . $request->avatar->getClientOriginalExtension();
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
        $usermanages->user_role = $request->user_role;
        $usermanages->modifieddate = now();
        $usermanages->birthday = $request->birthday;

        $usermanages->province_id = $request->province_id;
        $usermanages->department_id = $request->department_id;
        $usermanages->mobile = $request->mobile;

        $usermanages->pos_name = $request->pos_name;

        if (
            $request->departmentselect == 1 ||
            $request->departmentselect == 2
        ) {
            $usermanages->user_affiliation = $request->user_affiliation;
            if ($request->has('extender_id5')) {
                $usermanages->organization = $request->extender_id5;
            } elseif ($request->has('extender_id4')) {
                $usermanages->organization = $request->extender_id4;
            } elseif ($request->has('extender_id3')) {
                $usermanages->organization = $request->extender_id3;
            } elseif ($request->has('extender_id2')) {
                $usermanages->organization = $request->extender_id2;
            } elseif ($request->has('extender_id')) {
                $usermanages->organization = $request->extender_id;
            }
        } elseif ($request->departmentselect == 3) {


            $usermanages->organization = 0;
            if ($request->extender_id5) {
                $user_affiliation = DB::table('users_extender')
                    ->where('extender_id', $request->extender_id5)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation->content_name;
            } elseif ($request->extender_id4) {
                $user_affiliation1 = DB::table('users_extender')
                    ->where('extender_id', $request->extender_id4)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation1->content_name;
            } elseif ($request->extender_id3) {
                $user_affiliation2 = DB::table('users_extender')
                    ->where('extender_id', $request->extender_id3)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation2->content_name;
            } elseif ($request->extender_id2) {
                $user_affiliation3 = DB::table('users_extender')
                    ->where('extender_id', $request->extender_id2)
                    ->first();
         
                $usermanages->user_affiliation = $user_affiliation3->content_name;
            } elseif ($request->extender_id) {
                $user_affiliation4 = DB::table('users_extender')
                    ->where('extender_id', $request->extender_id)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation4->content_name;
   
            }
        }
        $usermanages->save();

        $department_data = $request->department_data;
        if (!empty($department_data)) {
            DB::table('users_department')
                ->where('user_id', $user_id)
                ->delete();

            $maxUserDepartmentId = DB::table('users_department')->max('user_department_id');
            foreach ($department_data as $departmentId) {
                $newUserDepartmentId = $maxUserDepartmentId + 1;
                DB::table('users_department')->insert([
                    'user_department_id' => $newUserDepartmentId,
                    'user_id' =>  $user_id,
                    'department_id' => $departmentId,
                ]);
                $maxUserDepartmentId = $newUserDepartmentId;
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

        $school = School::all();
        $provinces = Provinces::all();
        $role = UserRole::all();
        $extender_1 = DB::table('users_extender')->where('department', 6)->where('department_lv', 0)->where('status', 1)->get();
        $extender_2 = DB::table('users_extender')->where('department', 6)->where('department_lv', 1)->where('status', 1)->get();
        $extender_3 = DB::table('users_extender')->where('department', 6)->where('department_lv', 2)->where('status', 1)->get();
        $extender1 = DB::table('users_extender2')->where('item_lv', 1)->get();
        $extender2 = DB::table('users_extender2')->where('item_lv', 2)->get();
        $extender3 = DB::table('users_extender2')->where('item_lv', 3)->get();
        $extender4 = DB::table('users_extender2')->where('item_lv', 4)->get();
        $extender5 = DB::table('users_extender2')->where('item_lv', 5)->get();
        return view('page.UserAdmin.add.add_umsform', compact('role', 'school', 'provinces', 'extender1', 'extender2', 'extender3', 'extender4', 'extender5', 'extender_1', 'extender_2', 'extender_3'));
    }


    public function changeStatus(Request $request)
    {

        $usermanages = Users::find($request->user_id);

        // ตรวจสอบว่าหน้ามีค่า page_status ที่เป็น 1 หรือ 0
        if ($usermanages) {
            $usermanages->userstatus  = $request->userstatus;
            $usermanages->save();


            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล links']);
        }
    }

    public function autoschool(Request $request)
    {
        $provinceCode = $request->get('province');

        $query = School::select("school_name as value", "school_id")
            ->where('school_name', 'LIKE', '%' . $request->get('search') . '%');

        if (!empty($provinceCode)) {
            $query->where('provinces_code', $provinceCode);
        }

        $data = $query->get();

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
            'user_role' => 'required',
        ], [
            'username.required' => 'กรุณากรอก username',
            'username.unique' => 'มี username ซ้ำในระบบกรุณาเปลี่ยน',
            'firstname.required' => 'กรุณากรอก ชื่อจริง',
            'password.required' => 'กรุณากรอก password',
            'password.min' => 'password น้อยเกินไป ต้องมากกว่า 3 ตัวอักษร',
            'password.max' => 'password เยอะเกินไป ไม่เกิน 20 ตัวอักษร',
            'citizen_id.required' => 'กรุณากรอกเลขบัตรประชาชน หรือ passport',
            'citizen_id.unique' => 'มีเลขบัตรประชาชน หรือ passport ซ้ำในระบบ',
            'email.required' => 'กรุณากรอก email',
            'email.email' => 'กรุณาบกรอกรูปแบบ email เช่น email@gmail.com',
            'email.unique' => 'มี email ซ้ำในระบบกรุณาเปลี่ยน',
            'gender.required' => 'กรุณาเลือก เพศ ',
            'mobile.required' => 'กรุณากรอกเบอร์โทร',
            'user_role.required' => 'กรุณาเลือกประเภทผู้ใช้งาน',
        ]);
        $maxUserId = Users::max('user_id');
        $newUserId = $maxUserId + 1;
        $usermanages = new Users();
        $usermanages->user_id = $newUserId;
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

        $usermanages->user_type = null;
        $usermanages->province_id = $request->province_id;
        $usermanages->user_type_card =  $request->input('user_type_card', 0);


        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;

        if (
            $request->departmentselect == 1 ||
            $request->departmentselect == 2
        ) {
            $usermanages->user_affiliation = $request->user_affiliation;
            if ($request->has('extender_id5')) {
                $usermanages->organization = $request->extender_id5;
            } elseif ($request->has('extender_id4')) {
                $usermanages->organization = $request->extender_id4;
            } elseif ($request->has('extender_id3')) {
                $usermanages->organization = $request->extender_id3;
            } elseif ($request->has('extender_id2')) {
                $usermanages->organization = $request->extender_id2;
            } elseif ($request->has('extender_id')) {
                $usermanages->organization = $request->extender_id;
            }
        } elseif ($request->departmentselect == 3) {


            $usermanages->organization = 0;
            if ($request->extender_id5) {
                $user_affiliation = DB::table('users_extender')
                ->where('extender_id', $request->extender_id5)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation->content_name;
            } elseif ($request->extender_id4) {
                $user_affiliation1 = DB::table('users_extender')
                ->where('extender_id', $request->extender_id4)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation1->content_name;
            } elseif ($request->extender_id3) {
                $user_affiliation2 = DB::table('users_extender')
                ->where('extender_id', $request->extender_id3)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation2->content_name;
            } elseif ($request->extender_id2) {
                $user_affiliation3 = DB::table('users_extender')
                ->where('extender_id', $request->extender_id2)
                    ->first();

                $usermanages->user_affiliation = $user_affiliation3->content_name;
            } elseif ($request->extender_id) {
                $user_affiliation4 = DB::table('users_extender')
                ->where('extender_id', $request->extender_id)
                    ->first();
                $usermanages->user_affiliation = $user_affiliation4->content_name;
            }
        }


        $usermanages->save();


        $maxUserDepartmentId = DB::table('users_department')->max('user_department_id');
        $department_data = $request->department_data;
        if (!empty($department_data)) {
            foreach ($department_data as $departmentId) {
                $newUserDepartmentId = $maxUserDepartmentId + 1;
                DB::table('users_department')->insert([
                    'user_department_id' => $newUserDepartmentId,
                    'user_id' =>    $usermanages->user_id,
                    'department_id' => $departmentId,
                ]);
                $maxUserDepartmentId = $newUserDepartmentId;
            }
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
