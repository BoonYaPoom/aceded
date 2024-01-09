<?php

namespace App\Http\Controllers;


use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\SurveyQuestion;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Exam2Controller extends Controller
{
    public function exampage($department_id, $subject_id)
    {
      $subs  = CourseSubject::findOrFail($subject_id);
      $exams = $subs->eam()->where('subject_id', $subject_id)->get();
      $department_id =   $subs->department_id;
      $depart = Department::findOrFail($department_id);
      return view('page.manage.sub.exam.index', compact('subs', 'exams', 'depart'));
    }
    public function createexam($department_id, $subject_id)
    {
      $subs  = CourseSubject::findOrFail($subject_id);
      $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();
      $typequs = QuestionType::all();
      $lossen = CourseLesson::where('subject_id', $subject_id)->get();
      $department_id =   $subs->department_id;
      $depart = Department::findOrFail($department_id);
      return view('page.manage.sub.exam.dataexam.exam3.create', compact('subs', 'ques', 'typequs', 'lossen', 'depart'));
    }

    public function storeexam(Request $request, $department_id, $subject_id)
    {
      try {
        $maxExamId = Exam::max('exam_id');
        $newExamId = $maxExamId + 1;
        $exams = new Exam;
        $exams->exam_id = $newExamId;
        $exams->exam_th = $request->exam_th;
        $exams->exam_en = $request->exam_en;
        $exams->exam_type = 5;
        $exams->exam_status  = $request->exam_status;
        $exams->exam_score  = $request->exam_score;
        $exams->exam_options  = null;
        $exam_status = $request->input('exam_status', 0);
        $exams->exam_status = $exam_status;
        $exam_select = $request->input('exam_select', 0);
        $exams->exam_select = $exam_select;
        $showanswer = $request->input('showanswer', 0);
        $exams->showanswer = $showanswer;
        $showscore = $request->input('showscore', 0);
        $exams->showscore = $showscore;
        $limitdatetime = $request->input('limitdatetime', 0);
        $exams->limitdatetime = $limitdatetime;
        $limittime = $request->input('limittime', 0);
        $exams->limittime = $limittime;
        if ($exam_select == 0) {
          $exam_data = $request->input('exam_data');
          $exams->exam_data = !empty($exam_data) ? json_encode($exam_data) : '';
        } elseif ($exam_select == 1) {
          $exam_data1 = $request->input('randomdata');
          $exams->exam_data = !empty($exam_data1) ? json_encode($exam_data1) : '';
        }
        $exams->maxtake  = $request->maxtake;
        $exams->randomquestion   = $request->randomquestion;
        $exams->randomchoice   = $request->randomchoice;
        $time1 = $request->input('time1');
        $time2 = $request->input('time2');
        $data1 = $request->input('date1');
        $data2 = $request->input('date2');
        $exams->setdatetime = !empty($time1) || !empty($time2) || !empty($data1) || !empty($data2) ? json_encode(['date1' => $data1, 'date2' => $data2, 'time1' => $time1, 'time2' => $time2]) : '';
        $setminute = $request->input('setminute');
        $sethour = $request->input('sethour');
        $exams->settime = !empty($setminute) || !empty($sethour) ? json_encode(['hour' => $sethour, 'minute' => $setminute]) : '';
        $exams->survey_before   = $request->survey_before;
        $exams->survey_after   = $request->survey_after;
        $exams->lesson_id    = 0;
        $exams->perpage    = $request->perpage;
        $exams->score_pass   = $request->score_pass;
        $exams->subject_id = $subject_id;
  
        $exams->save();
  
        DB::commit();
        return redirect()->route('exampage', [$department_id, 'subject_id' => $subject_id])->with('message', 'Exam add successfully');
      } catch (\Exception $e) {
  
        DB::rollBack();
  
        return response()->view('error.error-500', [], 500);
      }
    }

    public function edit_examform($department_id, $subject_id, $exam_id)
  {
    $exams  = Exam::findOrFail($exam_id);
    $subject_id = $exams->subject_id;
    $ques = Question::where('subject_id', $subject_id)->get();
    $typequs = QuestionType::all();
    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $subject_id =  $exams->subject_id;
    $subs = CourseSubject::findOrFail($subject_id);
    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.dataexam.exam3.edit', compact('exams', 'subs', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function update_examform(Request $request, $department_id, $subject_id, $exam_id)
  {
    $exams  = Exam::findOrFail($exam_id);
    $exams->exam_th = $request->exam_th;
    $exams->exam_en = $request->exam_en;
    $exams->exam_status  = $request->exam_status;
    $exams->exam_score  = $request->exam_score;
    $exam_status = $request->input('exam_status', 0);
    $exams->exam_status = $exam_status;
    $exam_select = $request->input('exam_select', 0);
    $exams->exam_select = $exam_select;
    $showanswer = $request->input('showanswer', 0);
    $exams->showanswer = $showanswer;
    $showscore = $request->input('showscore', 0);
    $exams->showscore = $showscore;
    $limitdatetime = $request->input('limitdatetime', 0);
    $exams->limitdatetime = $limitdatetime;
    $limittime = $request->input('limittime', 0);
    $exams->limittime = $limittime;
    if ($exam_select == 0) {
      $exam_data = $request->input('exam_data');
      $exams->exam_data = !empty($exam_data) ? json_encode($exam_data) : '';
    } elseif ($exam_select == 1) {
      $exam_data1 = $request->input('randomdata');
      $exams->exam_data = !empty($exam_data1) ? json_encode($exam_data1) : '';
    }
    $exams->maxtake  = $request->maxtake;
    $exams->randomquestion   = $request->randomquestion;
    $exams->randomchoice   = $request->randomchoice;
    $time1 = $request->input('time1');
    $time2 = $request->input('time2');
    $data1 = $request->input('date1');
    $data2 = $request->input('date2');
    $exams->setdatetime = !empty($time1) || !empty($time2) || !empty($data1) || !empty($data2) ? json_encode(['date1' => $data1, 'date2' => $data2, 'time1' => $time1, 'time2' => $time2]) : '';
    $setminute = $request->input('setminute');
    $sethour = $request->input('sethour');
    $exams->settime = !empty($setminute) || !empty($sethour) ? json_encode(['hour' => $sethour, 'minute' => $setminute]) : '';
    $exams->survey_before   = $request->survey_before;
    $exams->survey_after   = $request->survey_after;
    $exams->perpage    = $request->perpage;
    $exams->score_pass   = $request->score_pass;
    $exams->save();
    return redirect()->route('exampage', [$department_id, $subject_id])->with('message', 'Exam add successfully');
  }

}
