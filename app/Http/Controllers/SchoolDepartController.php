<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\School;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SchoolDepartController extends Controller
{
    public function umsschooldepartment($department_id)
    {
        if (Session::has('loginId')) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $school = [];
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $depart = Department::findOrFail($department_id);
            $users  = $depart->UserDe()->where('department_id', $department_id);
            $userschool  = $depart->SchouserDe()->where('department_id', $department_id);
            $provinceId = $data->province_id;
            if ($data->user_role == 1 || $data->user_role == 8) {
                $school = School::where('department_id', $department_id)->get();
            } elseif ($data->user_role == 6 || $data->user_role == 7) {
                $school = School::where('provinces_id', $provinceId)
                    ->where('department_id', $department_id)->get();
            }
        }
        return view('layouts.department.item.data.UserAdmin.group.umsschool.index', compact('depart', 'users', 'school', 'userschool'));
    }

    public function indexschool($department_id)
    {
        if (Session::has('loginId')) {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $school = [];
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $depart = Department::findOrFail($department_id);
            $users  = $depart->UserDe()->where('department_id', $department_id);
            $userschool  = $depart->SchouserDe()->where('department_id', $department_id);
            $provinceId = $data->province_id;
            if ($data->user_role == 1 || $data->user_role == 8) {
                $school = School::where('department_id', $department_id)->get();
            } elseif ($data->user_role == 6 || $data->user_role == 7) {
                $school = School::where('provinces_code', $provinceId)
                    ->where('department_id', $department_id)->get();
            }
        }
        return view('layouts.department.item.data.UserAdmin.group.umsschool.index', compact('depart', 'users', 'school', 'userschool'));
    }

    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('layouts.department.item.data.UserAdmin.group.umsschool.create', compact('depart'));
    }

    public function store(Request $request, $department_id)
    {

        $school = new School;

        $school->school_name = $request->school_name;
        $school->provinces_code = $request->province_code;
        $school->subdistrict_code = null;
        $school->district_code = null;
        $school->department_id = $department_id;
        $school->save();
        $school->school_code = $school->school_id;
        $school->save();
        return redirect()->route('umsschooldepartment', ['department_id' => $department_id])->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }


    public function edit($department_id, $school_id)
    {
        $school = School::findOrFail($school_id);
        $depart = Department::findOrFail($department_id);
        return view('layouts.department.item.data.UserAdmin.group.umsschool.edit', ['school' => $school, 'depart' => $depart]);
    }

    public function update(Request $request, $department_id, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_name = $request->school_name;
        $school->provinces_code = $request->province_code;
        $school->subdistrict_code = null;
        $school->district_code = null;
        $school->save();
        $depart = Department::findOrFail($department_id);
        return redirect()->route('umsschooldepartment', ['department_id' => $depart->department_id])->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function delete($school_id)
    {
        $school = School::findOrFail($school_id);
        $school->delete();


        return redirect()->back()->with('message', 'PersonType ลบข้อมูลสำเร็จ');
    }
    public function adduser($department_id, $school_code)
    {
        $school = School::findOrFail($school_code);
        $userschool = $school->userScho()->where('school_code', $school->school_code)->get();

        $depart = Department::findOrFail($department_id);


        $users = $depart->UserDe()->where('department_id', $department_id)->get();



        return view('layouts.department.item.data.UserAdmin.group.umsschool.item.adduserschool', ['depart' => $depart, 'school' => $school, 'userschool' => $userschool, 'users' => $users]);
    }

    public function saveSelectedSchool(Request $request, $department_id, $school_code)

    {
        $school = School::findOrFail($school_code);
        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('user_school')->insert([
                'school_code' => $school->school_code,
                'user_id' => $userId,
                'department_id' => $department_id,
            ]);
        }

        return redirect()->back()->with('message', 'การบันทึก');
    }
}
