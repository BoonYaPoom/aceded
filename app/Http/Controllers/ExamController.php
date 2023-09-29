<?php

namespace App\Http\Controllers;

use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
  //exam หน้าสร้างชุดข้อสอบ
  public function exampage($subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $exams = $subs->eam()->where('subject_id', $subject_id)->get();

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.index', compact('subs', 'exams', 'depart'));
  }
  public function createexam($subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();
    $typequs = QuestionType::all();

    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.create', compact('subs', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function storeexam(Request $request, $subject_id)
  {
    try {
      $exams = new Exam;
      $exams->exam_th = $request->exam_th;
      $exams->exam_en = $request->exam_en;
      $exams->exam_type = 2;
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
    } catch (\Exception $e) {

      DB::rollBack();

      return response()->view('errors.500', [], 500);
    }

    return redirect()->route('exampage', ['subject_id' => $subject_id])->with('message', 'Exam add successfully');
  }
  public function edit_examform($exam_id)
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
    return view('page.manage.sub.exam.edit', compact('exams', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function update_examform(Request $request, $exam_id)
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
    return redirect()->route('exampage', ['subject_id' => $exams->subject_id])->with('message', 'Exam add successfully');
  }


  public function destroyexam($exam_id)
  {
    $exams = Exam::findOrFail($exam_id);

    $exams->delete();
    return redirect()->back()->with('message', 'Course_lesson delete successfully');
  }
  //question หน้าสร้างข้อสอบ
  public function pagequess($subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();
    $typequs = QuestionType::all();
    $lossen = CourseLesson::where('subject_id', $subject_id)->get();

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.questionadd', compact('subs', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function questionadd($subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.import', compact('subs', 'ques', 'depart'));
  }
  public function create($subject_id)
  {
    $typequs = QuestionType::all();

    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $subs  = CourseSubject::findOrFail($subject_id);

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.create', compact('subs', 'subject_id', 'typequs', 'lossen', 'depart'));
  }


  public function store(Request $request, $subject_id)
  {

    $validator = Validator::make($request->all(), [

      'question_type' => 'required',
      'question' => 'required',
      'lesson_id' => 'required'
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput()
        ->with('error', 'ข้อมูลไม่ถูกต้อง');
    }

    $ques = new Question;
    $ques->question = $request->question;
    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);
    $ques->choice1 = $request->choice1;


    $questions = [];
    for ($i = 1; $i <= 10; $i++) {
      $question = "q$i";
      if ($request->$question) {
        $questions[] = $request->$question;
      }
    }

    $ques->choice1 .= !empty($questions) ?  implode(',', $questions) : '';

    $ques->choice2 = $request->choice2;

    // สร้างอาร์เรย์เก็บตัวเลือกใหม่
    $coluques = [];
    for ($i = 1; $i <= 10; $i++) {
      $coluquesKey  = "c$i";
      if ($request->$coluquesKey) {
        $coluques[] = $request->$coluquesKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice2
    $ques->choice2 .= !empty($coluques) ?  implode(',', $coluques) : '';

    $ques->choice3 = $request->choice3;

    $quesanss = [];
    for ($i = 1; $i <= 10; $i++) {
      $quesansKey = "ans$i";
      if ($request->$quesansKey) {
        $quesanss[] = $request->$quesansKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice3
    $ques->choice3 .= !empty($quesanss) ? implode(',', $quesanss) : '';


    $ques->choice4 = $request->choice4;

    $queskos = [];
    for ($i = 1; $i <= 10; $i++) {
      $queskook = "o$i";
      if ($request->$queskook) {
        $queskos[] = $request->$queskook;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice4
    $ques->choice4 .= !empty($queskos) ?  implode(',', $queskos) : '';

    $ques->choice5 = $request->choice5;
    $ques->choice6 = $request->choice6;
    $ques->choice7 = $request->choice7;
    $ques->choice8 = $request->choice8;
    $ques->score = $request->score;
    $ques->numchoice = $request->numchoice;
    $ques->explain = $request->explain;
    $ques->answer = null;
    $ques->ordering = null;
    $ques->lesson_id = $request->lesson_id;
    $ques->subject_id = $subject_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', ['subject_id' => $subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
  }
  public function edit($question_id)
  {
    $ques  = Question::findOrFail($question_id);
    $typequs = QuestionType::all();
    $subject_id = $ques->subject_id;
    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $subject_id =  $ques->subject_id;
    $subs = CourseSubject::findOrFail($subject_id);
    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.edit', compact('typequs', 'lossen', 'ques', 'depart'));
  }

  public function update(Request $request, $question_id)
  {

    $ques = Question::findOrFail($question_id);
    $ques->question = $request->question;
    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);
    $ques->choice1 = $request->choice1;


    $questions = [];
    for ($i = 1; $i <= 10; $i++) {
      $question = "q$i";
      if ($request->$question) {
        $questions[] = $request->$question;
      }
    }

    $ques->choice1 .= !empty($questions) ?  implode(',', $questions) : '';

    $ques->choice2 = $request->choice2;

    // สร้างอาร์เรย์เก็บตัวเลือกใหม่
    $coluques = [];
    for ($i = 1; $i <= 10; $i++) {
      $coluquesKey  = "c$i";
      if ($request->$coluquesKey) {
        $coluques[] = $request->$coluquesKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice2
    $ques->choice2 .= !empty($coluques) ?  implode(',', $coluques) : '';

    $ques->choice3 = $request->choice3;

    $quesanss = [];
    for ($i = 1; $i <= 10; $i++) {
      $quesansKey = "ans$i";
      if ($request->$quesansKey) {
        $quesanss[] = $request->$quesansKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice3
    $ques->choice3 .= !empty($quesanss) ? implode(',', $quesanss) : '';


    $ques->choice4 = $request->choice4;

    $queskos = [];
    for ($i = 1; $i <= 10; $i++) {
      $queskook = "o$i";
      if ($request->$queskook) {
        $queskos[] = $request->$queskook;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice4
    $ques->choice4 .= !empty($queskos) ?  implode(',', $queskos) : '';

    $ques->choice5 = $request->choice5;
    $ques->choice6 = $request->choice6;
    $ques->choice7 = $request->choice7;
    $ques->choice8 = $request->choice8;
    $ques->score = $request->score;
    $ques->numchoice = $request->numchoice;
    $ques->explain = $request->explain;
    $ques->answer = null;
    $ques->ordering = null;
    $ques->lesson_id = $request->lesson_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', ['subject_id' => $ques->subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
  }

  public function destroy($question_id)
  {
    $ques = Question::findOrFail($question_id);

    $ques->delete();
    return redirect()->back()->with('message', 'Question ลบข้อมูลสำเร็จ');
  }

  public function queschangeStatus(Request $request)
  {
    $ques = Question::find($request->question_id);

    if ($ques) {
      $ques->question_status = $request->question_status;
      $ques->save();

      return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
    } else {
      return response()->json(['message' => 'ไม่พบข้อมูล Question']);
    }
  }
  public function changeStatus(Request $request)
  {
    $exams = Exam::find($request->exam_id);

    if ($exams) {
      $exams->exam_status = $request->exam_status;
      $exams->save();

      return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
    } else {
      return response()->json(['message' => 'ไม่พบข้อมูล Exam']);
    }
  }
}
