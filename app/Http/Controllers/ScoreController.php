<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Exam;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
  public function examlogpage($exam_id)
  {
    $exams  = Exam::findOrFail($exam_id);
    $subject_id = $exams->subject_id;
    $score = $exams->scorelog()->where('exam_id', $exam_id)->get();
    return view('page.manage.sub.exam.logexam', compact('exams', 'score'));
  }


  public function gpapage($department_id)
  {
    $depart  = Department::findOrFail($department_id);
    return view('page.manage.gpa.index', compact('depart'));
  }
  public function subscore($department_id)
  {

    $depart  = Department::findOrFail($department_id);
    $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();

    return view('page.manage.gpa.item.subjects.subscore', compact('subs', 'depart'));
  }
  public function listsubject($subject_id)
  {

    $subs  = CourseSubject::findOrFail($subject_id);
    $exams = $subs->eam()->where('subject_id', $subject_id)->get();
    $department_id = $subs->department_id;
    $depart  = Department::findOrFail($department_id);
    $scores = \App\Models\Score::whereHas('examlog', function ($query) use ($subject_id) {
      $query->where('subject_id', $subject_id)
          ->where('exam_type', 2); // Additional condition for 'exam_type'
  })
  ->latest('score_date') // Order the results by 'score_date' in descending order
  ->get();
  
    return view('page.manage.gpa.item.subjects.listsubject', compact('subs', 'scores',  'depart'));
  }
}
