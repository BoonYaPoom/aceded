<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Districts;
use App\Models\Subdistricts;
use App\Models\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EditManageUserController extends Controller
{

    public function UserManage(Request $request, $role = null)
    {
        $usermanages = Users::query();
    
        if ($role !== null) {
            $usermanages->where('role', $role);
        }
    
        $usermanages = $usermanages->get();
    
        return view('page.UserAdmin.indexview', compact('usermanages'));
    }
    
    
    
    

    public function edit($uid)
    {
        $usermanages = Users::findOrFail($uid);
        return view('page.UserAdmin.edit', ['usermanages' => $usermanages]);
    }


    public function update(Request $request, $uid)
    {

        $usermanages = Users::findOrFail($uid);

        if ($request->hasFile('avatar')) {
            $image_name = 'avatar' .  $uid . '.' . $request->avatar->getClientOriginalExtension();
            $image = Image::make($request->avatar)->resize(400, 400);
            $uploadDirectory = public_path('upload/Profile/' . $image_name);
            
            if (!file_exists(dirname($uploadDirectory))) {
                mkdir(dirname($uploadDirectory), 0755, true);
            }
        
            $image->save($uploadDirectory);
            $usermanages->avatar = 'upload/Profile/' . 'avatar' .  $uid .'.' . $request->avatar->getClientOriginalExtension();
        } else {
            $usermanages->avatar = ''; // Set to empty if no avatar is uploaded
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
        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }



    public function updateRoleUser(Request $request, $uid)
    {
        $roleValue = $request->input('role');

        // อัปเดตค่า role ในฐานข้อมูล
        $usermanages = Users::findOrFail($uid);
        $usermanages->role = $roleValue;
        $usermanages->save();

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }
    public function updatepassword(Request $request, $uid)
    {


        // อัปเดตค่า role ในฐานข้อมูล
        $usermanages = Users::findOrFail($uid);

        $usermanages->password = Hash::make($request->usearch);
        $usermanages->save();

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function createUser()
    {

        return view('page.UserAdmin.add.add_umsform');
    }


    public function changeStatus(Request $request)
    {
        $usermanages = Users::find($request->uid);

        if ($usermanages) {
            $usermanages->userstatus = $request->userstatus;
            $usermanages->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล usermanages']);
        }
    }



    // ใน Controller
    public function showByRole(Request $request, $role)
    {
        if ($role === '0') {
            $usermanages = Users::all();
        } else {
            $usermanages = Users::where('role', $role)->get();
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
            'role' => 'required',


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
        $usermanages->role =  $request->role;
        $usermanages->per_id = null;
        $usermanages->department_id = $request->department_id;

        $usermanages->permission = null;
        $usermanages->ldap = 0;
        $usermanages->userstatus = 1;
        $usermanages->createdate = now();
        $usermanages->createby = 2;
        $usermanages->avatar = '';
        $usermanages->position = '';
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

        $usermanages->save();

        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }



   
}
