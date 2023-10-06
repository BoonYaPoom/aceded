<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGroup;
use App\Models\CourseSubject;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseSubController extends Controller
{
    public function courseSub($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 

        return view('page.manage.group.co.structure.subject', compact('cour', 'courses','depart'));
    }
    public function subjecClass($subject_id)
    {
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id   = $subs->department_id;
        $depart = Department::findOrFail($department_id);
      

        return view('page.manage.group.co.structure.subjectItem.index', compact('subs','depart'));
    }
}
