<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\School;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolDepartController extends Controller
{
    public function schoolManage($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $users  = $depart->UserDe()->where('department_id', $department_id);
        $userschool = UserSchool::all();
        $school = School::all();
        return view('layouts.department.item.data.UserAdmin.group.umsschool.index', compact('depart','users', 'school', 'userschool'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);
 
        return view('layouts.department.item.data.UserAdmin.group.umsschool.create',compact('depart'));
    }

    public function store(Request $request,$department_id)
    {
        $depart = Department::findOrFail($department_id);
        $school = new School;
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->save();
        return redirect()->route('schoolManageDepart',['department_id'=>$depart->department_id])->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function edit($school_id)
    {
        $school = School::findOrFail($school_id);
        return view('layouts.department.item.data.UserAdmin.group.umsschool.edit', ['school' => $school]);
    }

    public function update(Request $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->save();
        return redirect()->route('schoolManageDepart')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function delete($school_id)
    {
        $school = School::findOrFail($school_id);
        $school->delete();


        return redirect()->back()->with('message', 'PersonType ลบข้อมูลสำเร็จ');
    }
    public function adduser($school_id)
    {
        $school = School::findOrFail($school_id);
        $userschool = $school->userScho()->where('school_id', $school_id)->get();
        $users = Users::all();


        return view('layouts.department.item.data.UserAdmin.group.umsschool.item.adduserschool', ['school' => $school, 'userschool' => $userschool, 'users' => $users]);
    }

    public function saveSelectedSchool(Request $request, $school_id)

    {

        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('user_school')->insert([
                'school_id' => $school_id,
                'user_id' => $userId,

            ]);
        }

        return redirect()->back()->with('success', 'การบันทึก');
    }
}
