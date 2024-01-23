<?php

namespace App\Http\Controllers;

use App\Models\ActivityInvite;
use App\Models\Department;
use App\Models\Extender2;
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

        return view("layouts.department.item.data.request.adminRequest.index", compact("mit", 'school'));
    }
    public function requestSchooldataJson()
    {

        $mit = SubmitSchool::all();
        $mitdata = [];
        $i = 1;

        $thaiEndDate = [];
        foreach ($mit as  $value) {
            $school = Extender2::where('extender_id', $value->extender_id)
                ->pluck('name')
                ->first();
            $mobile = $value->telephone;
            $exten = Extender2::where('extender_id', $value->extender_id)

                ->first();
            $fullname =  $value->firstname . ' ' . $value->lastname;
            $part1 = substr($mobile, 0, 3);
            $part2 = substr($mobile, 3, 3);
            $part3 = substr($mobile, 6, 4);
            $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
            $extenderData = Extender2::where('extender_id', $exten->item_parent_id)->first();
            $thaiStartDate = Carbon::parse($value->startdate)->locale('th')->addYears(543)->isoFormat('LL');

            $thaiEndDate = Carbon::parse($value->enddate)->locale('th')->addYears(543)->isoFormat('LL');
            $thaiEndDate = $value->enddate !== null ? $thaiEndDate : '';


            $mitdata[] = [
                "num" => $i++,
                "submit_id" => $value->submit_id,
                "school" => $school,
                "fullname" =>  $fullname,
                "telephone" =>  $fullMobile,
                "email" => $value->email,
                'proviUser' => $extenderData->name,
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
            'citizen_id' => 'required|unique:submit_school',
            'firstname' => 'required|unique:submit_school',
            'lastname' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'pos_name' => 'required',
            'submit_path' => 'required|mimes:pdf',
            'extender_id' =>   'unique:submit_school','extender_id5' => 'required_without_all:extender_id4,extender_id3,extender_id2,extender_id1|unique:submit_school',
            'extender_id4' => 'required_without_all:extender_id5,extender_id3,extender_id2,extender_id1',
            'extender_id3' => 'required_without_all:extender_id5,extender_id4,extender_id2,extender_id1',
            'extender_id2' => 'required_without_all:extender_id5,extender_id4,extender_id3,extender_id1',
            'extender_id1' => 'required_without_all:extender_id5,extender_id4,extender_id3,extender_id2',
        ], [
            'citizen_id.unique' => 'เลขบัตรนี้เคยขอรหัส admin ไปแล้ว',
            'citizen_id.required' => 'กรุณากรอกเลขบัตร ของคุณ',
            'firstname.unique' => 'ชื่อนี้เคยขอไปแล้ว admin ไปแล้ว',
            'lastname.required' => 'กรุณากรอกนามสกุล ของคุณ',
            'email.required' => 'กรุณากรอก email ของคุณ',
            'email.email' => 'กรุณากรอกรูปแบบ email',
            'telephone.required' => 'กรุณากรอก เบอร์โทรของคุณ',
            'pos_name.required' => 'กรุณากรอก ตำแหน่งของคุณ',
            'submit_path.required' => 'กรุณาแนบไฟล์',
            'submit_path.mimes' => 'PDF เท่านั้น',
            'extender_id.unique' => 'โรงเรียนนี้มีรหัสแอดมินไปแล้ว ไปแล้ว',
            'extender_id5.required_without_all' => 'กรุณาเลือกอย่างน้อยหนึ่งรายการ',
        ]);

        $mit = new SubmitSchool;
        $mit->department_id = $request->departmentselect;

        if ($request->extender_id5) {
            $mit->extender_id = $request->extender_id5;
        } elseif ($request->extender_id4) {
            $mit->extender_id = $request->extender_id4;
        } elseif ($request->extender_id3) {
            $mit->extender_id = $request->extender_id3;
        } elseif ($request->extender_id3) {
            $mit->extender_id = $request->extender_id2;
        } elseif ($request->extender_id2) {
            $mit->extender_id = $request->extender_id;
        }
    
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
        $school = Extender2::where('extender_id', $mit->extender_id)

            ->first();
        $extenderData = Extender2::where('extender_id', $school->item_parent_id)->first();
        $mobile = $mit->telephone;
        $part1 = substr($mobile, 0, 3);
        $part2 = substr($mobile, 3, 3);
        $part3 = substr($mobile, 6, 4);
        $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
        $thaiStartDate = Carbon::parse($mit->startdate)->locale('th')->isoFormat('LL');
        if ($mit->enddate !== null) {
            $thaiEndDate = Carbon::parse($mit->enddate)->locale('th')->isoFormat('LL');
        }
        $citizen_id = Users::where('organization', $mit->extender_id)
            ->where('user_role', 6)
            ->pluck('username')
            ->first();


        return view("layouts.department.item.data.request.adminRequest.detail", compact("mit", 'school', 'citizen_id', 'extenderData', 'fullMobile', 'thaiStartDate', 'thaiEndDate'));
    }

    public function storeAdminreq(Request $request, $submit_id)
    {


        $mit =  SubmitSchool::findOrFail($submit_id);
        $mit->submit_status = 1;
        $mit->enddate = now();
        $mit->save();
        $school = Extender2::where('extender_id', $mit->extender_id)
            ->first();
        $extenderData = Extender2::where('extender_id', $school->item_parent_id)->first();

        $maxUserId = Users::max('user_id');
        $newUserId = $maxUserId + 1;
        $usermanages = new Users();
        $usermanages->user_id = $newUserId;
        $usermanages->username = str_pad($mit->extender_id, 5, '0', STR_PAD_RIGHT);
        $usermanages->firstname = $school->name;
        $usermanages->lastname = $extenderData->name;
        $usermanages->password = Hash::make(str_pad($mit->extender_id, 5, '0', STR_PAD_RIGHT));
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
        $usermanages->user_type = 1;
        $usermanages->province_id = $mit->province_id;
        $usermanages->user_type_card =  1;
        $usermanages->district_id = null;
        $usermanages->subdistrict_id = null;
        $usermanages->birthday = null;
        $usermanages->user_affiliation = 0;
        $usermanages->organization =  $mit->extender_id;
        $usermanages->user_type_card =  0;
        $usermanages->save();
        if (in_array($mit->department_id, [1, 2, 3, 4])) {
            $department_data = Department::whereIn('department_id', [1, 2, 3, 4])->get();
            $maxUserDepartmentId = DB::table('users_department')->max('user_department_id');
            foreach ($department_data as $departmentId) {
                $deuser = $maxUserDepartmentId + 1;
                DB::table('users_department')->insert([
                    'user_department_id' => $deuser + 1,
                    'user_id' =>    $usermanages->user_id,
                    'department_id' => $departmentId->department_id,
                ]);
                $maxUserDepartmentId = $deuser;
            }
        } elseif ($mit->department_id == 5) {
            $department_data = Department::where('department_id', 5)->get();
            $maxUserDepartmentId = DB::table('users_department')->max('user_department_id');
            foreach ($department_data as $departmentId) {
                $deuser = $maxUserDepartmentId + 1;
                DB::table('users_department')->insert([
                    'user_department_id' => $deuser + 1,
                    'user_id' =>    $usermanages->user_id,
                    'department_id' => $departmentId->department_id,
                ]);
                $maxUserDepartmentId = $deuser;
            }
        }

        $inva = new ActivityInvite;
        $inva->activity_id  = 0;
        $inva->user_id  = $mit->user_id;
        $inva->message  = 'คุณได้รับสิทธิ์ ในการเป็น Admin สถานศึกษารหัสผ่าน username =' . "\n" .  $usermanages->username . "\n" . 'password =' .  $usermanages->username;
        $inva->activity_date  = now();
        $inva->status  = 1;
        $inva->activity_type  = 7;
        $inva->from_id  = 0;
        $inva->save();

        return redirect()->route('detaildata', $submit_id)->with('message', 'ยืนยันรับสิทธิ์สำเร็จ');
    }
    public function storeAdminreq2($submit_id)
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
