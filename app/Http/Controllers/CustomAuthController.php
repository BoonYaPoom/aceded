<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Log;
use App\Models\Provinces;
use App\Models\Subdistricts;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class CustomAuthController extends Controller
{
    public function login(){
        return view('Authpage.Login.login');
    }
  
    
    public function regis()
    {
        $provinces = Provinces::all();
        $districts = Districts::all();
        $supdist = Subdistricts::all();

        return view('Authpage.Regis.registration', compact('provinces', 'districts','supdist'));
    }

    

    public function homeregis(){
        
        return view('Authpage.Regis.home');
    }
    public function registerUser(Request $request){
        $request->validate([

            'username'=> 'required|unique:users',
            'firstname'=> 'required',
            'password'=> 'required|min:3|max:20',
            'citizen_id'=> 'required|min:13|max:13',
            'email'=> 'required|email|unique:users',
            'gender'=> 'required',
            'workplace'=> 'required',
            'mobile'=> 'required',
            'user_type'=> 'required',
          

        ]);
       
        $users = new Users();
        $users->username = $request->username;
        $users->firstname = $request->firstname;
        $users->lastname = $request->lastname;
        $users->password = Hash::make($request->password);
        $users->citizen_id = $request->citizen_id;
        $users->prefix  = '';
        $users->gender = $request->input('gender', 0);
        $users->email = $request->email;
        $users->role = 5;
        $users->per_id = null;
        $users->department_id = 12;

        $users->permission = null;
        $users->ldap = 0;
        $users->userstatus = 1;
        $users->createdate = now();
        $users->createby = 2;
        $users->avatar = '';
        $users->position = '';
        $users->workplace = $request->workplace;
        $users->telephone = '';
        $users->mobile = $request->mobile;
        $users->socialnetwork = '';
        $users->experience = null;
        $users->recommened = null;
        $users->templete = null;
        $users->nickname = '';
        $users->introduce = '';
        $users->bgcustom = '';
        $users->pay = '';
        $users->education = '';
        $users->teach = '';
        $users->modern = '';
        $users->other = '';
        $users->profiles = null;
        $users->editflag = null;
        $users->pos_level = 0;
        $users->pos_name = $request->pos_name;
        $users->sector_id = 0;
        $users->office_id = 0;

        $users->user_type = $request->input('user_type', 0);
        $users->province_id = $request->province_id;
        $users->district_id = $request->district_id;
        $users->subdistrict_id = $request->subdistrict_id;

        $res = $users->save();

        if ($res) {
            if (Hash::check($request->password, $users->password)) {
                // รหัสผ่านถูกต้อง
                return redirect()->route('homelogin')->with('message', 'Users บันทึกข้อมูลสำเร็จ');
            } else {
                // รหัสผ่านไม่ถูกต้อง
                // ดำเนินการต่อที่คุณต้องการ
            }
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }



    public function loginUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:3|max:20'
        ]);
    
        $user = Users::where('username', '=', $request->username)->first();
    
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->role == 1 || $user->role == 3 && $user->userstatus == 1) {
                    $request->session()->put('loginId', $user->uid);
                    return redirect()->route('departmentdlspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                } else {
                    return back()->with('fail', 'ผู้ใช้ไม่มีสิทธิ์ในการเข้าสู่ระบบ');
                }
            } else {
                return back()->with('fail', 'รหัสผ่านไม่ถูกต้อง');
            }
        } else {
            return back()->with('fail', 'ไม่พบผู้ใช้ในระบบ');
        }
    }
    
   
   
    public function adminpage(){

        $data = array();
        if(Session::has('loginId')){
           $data = Users::where('uid', '=', Session::get('loginId'))->first();
        }
        return   view('layouts.adminhome',compact('data'));
    }
    public function logoutUser(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            
           return redirect()->route('homelogin')->with('message', 'ผู้ใช้ออกจากระบบ');
        }
       
    }

}
