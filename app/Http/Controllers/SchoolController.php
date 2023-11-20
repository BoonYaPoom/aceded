<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Provinces;
use App\Models\School;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function schoolManage()
    {
        set_time_limit(0);
        $users = Users::all();
        $userschool = UserSchool::all();
        $school = School::all();

        return view('page.UserAdmin.group.umsschool.index', compact('users', 'school', 'userschool'));
    }
    public function getSchools(Request $request )
    {
        $schools = School::all();
        $schoolsaa = [];
        $userschool = UserSchool::all();
        $i = 1;
        foreach ($schools as $school) {
            $proviUser = Provinces::where('code', $school->provinces_code)
                ->pluck('name_in_thai')
                ->first();
            $userCount = $userschool->where('school_code', $school->school_code)->count();
            ini_set('memory_limit', '1028M');
            $schoolsaa[] = [
                'num' => $i++,
                'id' => $school->school_id,
                'code' => $school->school_code,
                'school_name' => $school->school_name,
                'province_name' => $proviUser,
                'userCount' => $userCount,

            ];
            $allschool = [
                'recordsTotal' => count($schoolsaa), // รวมทั้งหมด
                'schoolsaa' => $schoolsaa,
            ];

        }

        return response()->json(['schoolsaa' => $schoolsaa]);
    }


    public function create()
    {
        $depart = Department::all();
        return view('page.UserAdmin.group.umsschool.create', compact('depart'));
    }

    public function store(Request $request)
    {
        $school = new School;
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->department_id = $request->department_id;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function edit($school_id)
    {
        $school = School::findOrFail($school_id);
        $depart = Department::all();
        return view('page.UserAdmin.group.umsschool.edit', ['school' => $school, 'depart' => $depart]);
    }

    public function update(Request $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_name = $request->school_name;
        $school->provinces_code = $request->code;

        $school->department_id = $request->department_id;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function delete($school_id)
    {
        $school = School::findOrFail($school_id);
        $school->delete();


        return redirect()->back()->with('message', 'school ลบข้อมูลสำเร็จ');
    }
    public function adduser($school_code)
    {
        $school = School::findOrFail($school_code);
        $userschool = $school->userScho()->where('school_code', $school->school_code)->get();
        $users = Users::all();


        return view('page.UserAdmin.group.umsschool.item.adduserschool', ['school' => $school, 'userschool' => $userschool, 'users' => $users]);
    }

    public function saveSelectedSchool(Request $request, $school_code)

    {
        $school = School::findOrFail($school_code);
        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('user_school')->insert([
                'school_code' => $school->school_code,
                'user_id' => $userId,

            ]);
        }

        return redirect()->back()->with('message', 'การบันทึก');
    }
}
