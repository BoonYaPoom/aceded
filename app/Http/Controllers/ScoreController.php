<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function examlogpage($exam_id) {
        $exams  = Exam::findOrFail($exam_id);   
        $subject_id = $exams->subject_id;
        $score = $exams->scorelog()->where('exam_id', $exam_id)->get(); 
        return view('page.manage.sub.exam.logexam', compact('exams','score'));
      }
}
