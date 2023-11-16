<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Log;
use App\Models\Provinces;
use App\Models\School;
use App\Models\Subdistricts;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use LdapRecord\Container;


class CustomAuthController extends Controller
{
    public function login()
    {
        return view('Authpage.Login.login');
    }
    public function loginLdap()
    {
        return view('Authpage.Login.ldaplogin');
    }

    public function regis()
    {
        $provinces = Provinces::all();
        $districts = Districts::all();
        $supdist = Subdistricts::all();

        return view('Authpage.Regis.registration', compact('provinces', 'districts', 'supdist'));
    }



    public function homeregis()
    {
        $school = School::all();
        $provinces = Provinces::all();
        return view('Authpage.Regis.home', compact('provinces','school'));
    }
    public function registerUser(Request $request)
    {
        $request->validate([

            'username' => 'required|unique:users',
            'firstname' => 'required',
            'password' => 'required|min:3|max:20',
            'citizen_id' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'gender' => 'required',
            'workplace' => 'required',
            'mobile' => 'required',
            'user_type' => 'required',


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
        $users->user_role = 5;
        $users->per_id = null;
        $users->department_id = 1;

        $users->permission = null;
        $users->ldap = 0;
        $users->userstatus = 1;
        $users->createdate = now();
        $users->createby = 2;
        $users->avatar = '';
        $users->user_position = '';
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
        try {
            $user = Users::where('username', '=', $request->username)->first();

            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->user_role == 1 || $user->user_role == 6 && $user->userstatus == 1 || $user->user_role == 7 && $user->userstatus == 1 || $user->user_role == 8 && $user->userstatus == 1|| $user->user_role == 3 && $user->userstatus == 1) {
                        $request->session()->put('loginId', $user->user_id);
                        return redirect()->route('departmentwmspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                    } else {
                        return back()->with('fail', 'ผู้ใช้ไม่มีสิทธิ์ในการเข้าสู่ระบบ');
                    }
                } else {
                    return back()->with('fail', 'รหัสผ่านไม่ถูกต้อง');
                }
            } else {
                return back()->with('fail', 'ไม่พบผู้ใช้ในระบบ');
            }
        } catch (\Exception $e) {
            return response()->view('error.error-500', [], 500);
        }
    }

    public function loginLdapUser(Request $request)
    {
        $ldap_host = env('LDAP_HOST');
        $ldap_port = env('LDAP_PORT');
        $ldap_connection = ldap_connect($ldap_host, $ldap_port);
        if ($ldap_connection) {
            $username = $request->input('username'); // Get the username from the form
            $password = $request->input('password'); // Get the password from the form
            $base_dn = "ou=users,dc=nacc,dc=go,dc=th"; // Update with your LDAP base DN


            ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

            $bind = ldap_bind($ldap_connection, "cn=$username,$base_dn", $password);
            if ($bind) {
                // ตรวจสอบว่าผู้ใช้งานอยู่ในฐานข้อมูลแล้วหรือไม่
                $userExists = Users::where('username', $username)->first();

                if (!$userExists) {
                    $randomcitizen = random_int(1000000000000, 9999999999999);
                    $randomtell = random_int(1000000000, 9999999999);
                    $users = new Users();
                    $users->username = $request->username;
                    $users->firstname = $request->username;
                    $users->lastname = $request->username;
                    $users->password = Hash::make($request->password);
                    $users->citizen_id = $randomcitizen;
                    $users->prefix  = '';
                    $users->gender = 1;
                    $users->email = $request->username . '@gmail.com';
                    $users->user_role = 1;
                    $users->per_id = null;
                    $users->department_id = 1;
                    $users->permission = null;
                    $users->ldap = 1;
                    $users->userstatus = 1;
                    $users->createdate = now();
                    $users->createby = 2;
                    $users->avatar = '';
                    $users->user_position = '';
                    $users->workplace = 'aa';
                    $users->telephone = '';
                    $users->mobile =  $randomtell;
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
                    $users->pos_name = 0;
                    $users->sector_id = 0;
                    $users->office_id = 0;

                    $users->user_type = null;
                    $users->province_id = null;
                    $users->district_id = null;
                    $users->subdistrict_id = null;

                    $users->save();

                    $request->session()->put('loginId', $users->user_id);
                    return redirect()->route('departmentwmspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                } elseif ($userExists) {
                    $request->session()->put('loginId', $userExists->user_id);
                    return redirect()->route('departmentwmspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                } else {
                    return back()->with('fail', 'ผู้ใช้ไม่มีสิทธิ์ในการเข้าสู่ระบบ');
                }
            } else {
                return back()->with('fail', 'ชื่อผู้ใช้ไม่มีอยู่ใน LDAP หรือรหัสผ่านไม่ถูกต้อง');
            }
        } else {
            return back()->with('fail', 'ผู้ใช้ไม่ใช่ LDAP ในการเข้าสู่ระบบ');
        }
    }


    public function adminpage()
    {

        $data = array();
        if (Session::has('loginId')) {
            $data = Users::where('user_id', '=', Session::get('loginId'))->first();
        }
        return   view('layouts.adminhome', compact('data'));
    }
    public function logoutUser()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');

            return redirect()->route('homelogin')->with('message', 'ผู้ใช้ออกจากระบบ');
        }
    }
    public function loginLdapUsertest(Request $request)
    {

        try {
            $ldap_host = env('LDAP_HOST');
            $ldap_port = env('LDAP_PORT');
            $ldap_connection = ldap_connect($ldap_host, $ldap_port);

            if ($ldap_connection) {
                $username = $request->input('username'); // Get the username from the form
                $password = $request->input('password'); // Get the password from the form
                $base_dn = "ou=users,dc=nacc,dc=go,dc=th"; // Update with your LDAP base DN


                ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

                $bind = ldap_bind($ldap_connection, "cn=$username,$base_dn", $password);
                if ($bind) {
                    // ตรวจสอบว่าผู้ใช้งานอยู่ในฐานข้อมูลแล้วหรือไม่
                    $userExists = Users::where('username', $username)->first();

                    if (!$userExists) {
                        $randomcitizen = random_int(1000000000000, 9999999999999);
                        $randomtell = random_int(1000000000, 9999999999);
                        $users = new Users();
                        $users->username = $username;
                        $users->firstname = $request->username;
                        $users->lastname = $request->username;
                        $users->password = Hash::make($password);
                        $users->citizen_id = $randomcitizen;
                        $users->prefix  = '';
                        $users->gender = 1;
                        $users->email = $request->username . '@gmail.com';
                        $users->user_role = 1;
                        $users->per_id = null;
                        $users->department_id = 1;
                        $users->permission = null;
                        $users->ldap = 1;
                        $users->userstatus = 1;
                        $users->createdate = now();
                        $users->createby = 2;
                        $users->avatar = '';
                        $users->user_position = '';
                        $users->workplace = 'aa';
                        $users->telephone = '';
                        $users->mobile =  $randomtell;
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
                        $users->pos_name = 0;
                        $users->sector_id = 0;
                        $users->office_id = 0;

                        $users->user_type = null;
                        $users->province_id = null;
                        $users->district_id = null;
                        $users->subdistrict_id = null;

                        $res = $users->save();
                        if ($res) {
                            $request->session()->put('loginId', $users->user_id);

                            return redirect()->route('departmentwmspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                        }
                    } else {
                        $request->session()->put('loginId', $userExists->user_id);

                        return redirect()->route('departmentwmspage')->with('message', 'ผู้ใช้เข้าสู่ระบบ');
                    }
                } else {
                    return back()->with('fail', 'ผู้ใช้ไม่ใช่ LDAP ในการเข้าสู่ระบบ');
                }
            }
        } catch (\Exception $e) {
            return back()->with('fail', 'ผู้ใช้ไม่มีสิทธิ์ในการเข้าสู่ระบบแบบ LDAP');
        }
    }
}
