<?php

namespace App\Http\Controllers;

use App\Models\Provinces;
use App\Models\School;
use App\Models\SubmitSchool;
use App\Models\Users;
use App\Models\UserSchool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubmitController extends Controller
{


    public function requestSchool()
    {
        $school = School::all();

        $mit = SubmitSchool::all();
        return view("layouts.department.item.data.request.index", compact("mit", 'school'));
    }
    public function requestSchooldataJson()
    {

        $mit = SubmitSchool::all();
        $mitdata = [];
        $i = 1;

        $thaiEndDate = [];
        foreach ($mit as  $value) {
            $school = School::where('school_id', $value->school_id)
                ->pluck('school_name')
                ->first();
            $proviUser = Provinces::where('code', $value->provines_code)
                ->pluck('name_in_thai')
                ->first();
            $mobile = $value->telephone;
            $fullname =  $value->firstname . ' ' . $value->lastname;
            $part1 = substr($mobile, 0, 3);
            $part2 = substr($mobile, 3, 3);
            $part3 = substr($mobile, 6, 4);
            $fullMobile = $part1 . '-' . $part2 . '-' . $part3;

            $thaiStartDate = Carbon::parse($value->startdate)->locale('th')->isoFormat('LL');
            if ($value->enddate !== null) {
                $thaiEndDate = Carbon::parse($value->enddate)->locale('th')->isoFormat('LL');
            }

            $mitdata[] = [
                "num" => $i++,
                "submit_id" => $value->submit_id,
                "school" => $school,
                "proviUser" => $proviUser,
                "fullname" =>  $fullname,
                "telephone" =>  $fullMobile,
                "email" => $value->email,
                "citizen_id" => $value->citizen_id,
                "pos_name" => $value->pos_name,
                "submit_path" => $value->submit_path,
                "submit_status" => $value->submit_status,
                "startdate" => $thaiStartDate,
                "enddate" => $thaiEndDate,
            ];
        }


        return response()->json(['mitdata' => $mitdata]);
    }

    public function store(Request $request)
    {
        $mit = new SubmitSchool;
        $mit->school_id = $request->school_id;
        $mit->provines_code = $request->provines_code;

        $mit->submit_status = 0;
        $mit->firstname = $request->firstname;
        $mit->lastname = $request->lastname;
        $mit->citizen_id = $request->citizen_id;
        $mit->telephone = $request->telephone;
        $mit->email = $request->email;
        $mit->pos_name = $request->pos_name;

        if ($request->hasFile('submit_path')) {
            $image = $request->file('submit_path');
            $imageName =  $image->getClientOriginalName();
            $image->move(public_path('upload/submit_path/'), $imageName);
            $mit->submit_path = 'upload/submit_path/' . $imageName;
        }

        $mit->startdate = now();
        $mit->enddate = '';
        $mit->save();

        return redirect('https://aced-lb.nacc.go.th/')->with('message', 'ส่งคำขอเรียบร้อย');
    }


    public function detaildata(Request $request, $submit_id)
    {



        $mit =  SubmitSchool::findOrFail($submit_id);
   

        
        $thaiEndDate = [];
        $school = School::where('school_id', $mit->school_id)
            ->pluck('school_name')
            ->first();
        $proviUser = Provinces::where('code', $mit->provines_code)
            ->pluck('name_in_thai')
            ->first();
        $mobile = $mit->telephone;

        $part1 = substr($mobile, 0, 3);
        $part2 = substr($mobile, 3, 3);
        $part3 = substr($mobile, 6, 4);
        $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
        $thaiStartDate = Carbon::parse($mit->startdate)->locale('th')->isoFormat('LL');
        if ($mit->enddate !== null) {
            $thaiEndDate = Carbon::parse($mit->enddate)->locale('th')->isoFormat('LL');
        }
        return view("layouts.department.item.data.request.detail", compact("mit", 'school', 'proviUser', 'fullMobile', 'thaiStartDate', 'thaiEndDate'));
    }

    public function storeAdmin(Request $request, $submit_id)
    {
        $mit =  SubmitSchool::findOrFail($submit_id);
        $mit->submit_status = 1;
        $mit->enddate = now();
        $mit->save();

        $usermanages = new Users();
        $usermanages->username = $request->username;
        $usermanages->firstname = $request->firstname;
        $usermanages->lastname = $request->lastname;
        $usermanages->password = Hash::make($request->password);
        $usermanages->citizen_id = $request->citizen_id;
        $usermanages->prefix  = '';
        $usermanages->gender = 1;
        $usermanages->email = $request->email;
        $usermanages->user_role =  6;
        $usermanages->per_id = null;
        $usermanages->department_id = '';

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


        $userschool = new UserSchool;
        $userschool->school_id = $mit->school_id;
        $userschool->user_id = $usermanages->user_id;
        $userschool->save();

        $department_data = $request->department_data;
        foreach ($department_data as $departmentId) {
            DB::table('users_department')->insert([
                'user_id' =>    $usermanages->user_id,
                'department_id' => $departmentId,
            ]);
        }
        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }
}
