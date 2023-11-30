<?php

namespace App\Http\Controllers;


use App\Models\CourseSubject;
use App\Models\CourseTeacher;
use App\Models\Department;
use App\Models\UserDepartment;
use App\Models\Users;
use Illuminate\Http\Request;

class CourseTeacherController extends Controller
{
    public function teacherspage($department_id, $subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $teachers = $subs->teachersup()->where('subject_id', $subject_id)->get();

        $department_id   = $subs->department_id;
        $depart = Department::findOrFail($department_id);

        $userDepart = UserDepartment::where('department_id', $department_id);
        $userIds = $userDepart->pluck('user_id');
        $usersNotInTeachers = Users::whereNotIn('user_id', $teachers->pluck('user_id'))
            ->whereIn('user_id', $userIds)
            ->where('userstatus', 1)
            ->where('user_role', 3)
            ->get();


        return view('page.manage.sub.teacher.index', compact('subs', 'teachers', 'depart', 'usersNotInTeachers'));
    }


    public function update(Request $request)
    {
        $teacherId = $request->input('teacher_id');
        $teacherStatus = $request->input('teacher_status');

        $teacher = CourseTeacher::find($teacherId);

        if ($teacher) {
            $teacher->teacher_status = $teacherStatus;
            $teacher->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Teacher']);
        }
    }
    public function create(Request $request,$department_id, $subject_id,$user_id)
    {
        $teacher = new CourseTeacher;
        $teacher->user_id = $request->user_id;
        $teacher->teacher_status = 1;
        $teacher->subject_id = $subject_id;
        $teacher->save();

        return redirect()->back()->with('message', 'CourseSub ลบข้อมูลสำเร็จ');
    }
    public function destory($teacher_id)
    {
        $teacher = CourseTeacher::find($teacher_id);

        $teacher->delete();
        return redirect()->back()->with('message', 'CourseSub ลบข้อมูลสำเร็จ');
    }
}
