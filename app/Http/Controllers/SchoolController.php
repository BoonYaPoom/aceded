<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function schoolManage()
    {
        $users = Users::all();
        $userschool = UserSchool::all();
        $school = School::all();
        return view('page.UserAdmin.group.umsschool.index', compact('users', 'school', 'userschool'));
    }
    public function create()
    {

        return view('page.UserAdmin.group.umsschool.create');
    }

    public function store(Request $request)
    {
        $school = new School;
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function edit($school_id)
    {
        $school = School::findOrFail($school_id);
        return view('page.UserAdmin.group.umsschool.edit', ['school' => $school]);
    }

    public function update(Request $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
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


        return view('page.UserAdmin.group.umsschool.item.adduserschool', ['school' => $school, 'userschool' => $userschool, 'users' => $users]);
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