<?php

namespace App\Http\Controllers;

use App\Models\ActivityInvite;
use App\Models\Department;
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


    public function requestSchool(Request $request)
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
            $school = School::where('school_code', $value->school_code)
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

    public function store(Request $request, $uid = null)
    {

        $request->validate([
            'citizen_id' => 'unique:users',
        ], [
            'citizen_id.unique' => 'เลขบัตรนี้เคยขอรหัส admin ไปแล้ว',
        ]);

        $mit = new SubmitSchool;
        $mit->school_code = $request->school_code;
        $mit->provines_code = $request->provines_code;
        $mit->user_id = $uid;
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


    public function detaildata($submit_id)
    {
        $mit =  SubmitSchool::findOrFail($submit_id);
        $thaiEndDate = [];
        $school = School::where('school_code', $mit->school_code)
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
        $citizen_id = Users::where('citizen_id', $mit->citizen_id)
            ->pluck('username')
            ->first();


        return view("layouts.department.item.data.request.detail", compact("mit", 'school','citizen_id', 'proviUser', 'fullMobile', 'thaiStartDate', 'thaiEndDate'));
    }

    public function storeAdminreq(Request $request, $submit_id)
    {


        $mit =  SubmitSchool::findOrFail($submit_id);
        $mit->submit_status = 1;
        $mit->enddate = now();
        $mit->save();
        $school = School::where('school_code', $mit->school_code)
        ->pluck('school_name')
        ->first();
        $proviUser = Provinces::where('code', $mit->provines_code)
        ->pluck('name_in_thai')
        ->first();


        $usermanages = new Users();
        $usermanages->username =  $mit->school_code;
        $usermanages->firstname = $school;
        $usermanages->lastname = $proviUser;
        $usermanages->password = Hash::make($mit->school_code);
        $usermanages->citizen_id = $mit->citizen_id;
        $usermanages->prefix  = '';
        $usermanages->gender = 1;
        $usermanages->email = $mit->email;
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
        $usermanages->mobile = $mit->telephone;
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
        $usermanages->pos_name = $mit->pos_name;
        $usermanages->sector_id = 0;
        $usermanages->office_id = 0;
        $usermanages->birthday = null;
        $usermanages->user_affiliation = null;
        $usermanages->user_type = 1 ;
        $usermanages->province_id = $mit->province_id;
        $usermanages->user_type_card =  1;
        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;

        $usermanages->save();


        $userschool = new UserSchool;
        $userschool->school_code = $mit->school_code;
        $userschool->user_id = $usermanages->user_id;
        $userschool->save();

        $department_data = Department::all();
        foreach ($department_data as $departmentId) {
            DB::table('users_department')->insert([
                'user_id' =>    $usermanages->user_id,
                'department_id' => $departmentId->department_id,
            ]);
        }

        $inva = new ActivityInvite;
        $inva->activity_id  = 0;
        $inva->user_id  = $submit_id->user_id;
        $inva->message  = 'คุณได้รับสิทธิ์ ในการเป็น Admin สถานศึกษารหัสผ่าน username ='. $mit->school_code . ' ' . 'password ='. $mit->school_code;
        $inva->activity_date  = now();
        $inva->status  = 1;
        $inva->activity_type  = 7;
        $inva->from_id  = 0;
        $inva->save();

        return redirect()->route('detaildata', $submit_id)->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }
    public function storeAdminreq2( $submit_id)
    {


        $mit =  SubmitSchool::findOrFail($submit_id);
        $mit->submit_status = 2;
        $mit->enddate = now();
        $mit->save();

        $inva = new ActivityInvite;
        $inva->activity_id  = 0;
        $inva->user_id  = $mit->user_id;
        $inva->message  = 'คุณไม่ได้รับสิทธิ์ในการเป็น admin สถานศึกษา';
        $inva->activity_date  = now();
        $inva->status  = 1;
        $inva->activity_type  = 7;
        $inva->from_id  = 0;
        $inva->save();

        return redirect()->route('detaildata', $submit_id)->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }
}
