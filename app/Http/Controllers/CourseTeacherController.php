<?php

namespace App\Http\Controllers;


use App\Models\CourseSubject;
use App\Models\CourseTeacher;
use Illuminate\Http\Request;

class CourseTeacherController extends Controller
{
    public function teacherspage($subject_id) {
        $subs  = CourseSubject::findOrFail($subject_id);
        $teachers = $subs->teachersup()->where('subject_id', $subject_id)->get(); 
        
       
        return view('page.manage.sub.teacher.index', compact('subs', 'teachers'));
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
    public function destory($teacher_id){
        $teacher = CourseTeacher::find($teacher_id);
    
         $teacher->delete();
     return redirect()->back()->with('message', 'CourseSub ลบข้อมูลสำเร็จ');

}
}
