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

class ExamController extends Controller
{
  //exam หน้าสร้างชุดข้อสอบ
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
    return view('page.manage.sub.exam.create', compact('subs', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function storeexam(Request $request, $department_id, $subject_id)
  {
    try {
      $exams = new Exam;
      $exams->exam_th = $request->exam_th;
      $exams->exam_en = $request->exam_en;
      $exams->exam_type = 3;
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

      return response()->view('error.error-500', [], 500);
    }

    return redirect()->route('exampage', [$department_id, 'subject_id' => $subject_id])->with('message', 'Exam add successfully');
  }
  public function edit_examform($department_id, $exam_id)
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
  public function update_examform(Request $request, $department_id, $exam_id)
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
  public function pagequess($department_id, $subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();
    $typequs = QuestionType::all();
    $lossen = CourseLesson::where('subject_id', $subject_id)->get();

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.questionadd', compact('subs', 'ques', 'typequs', 'lossen', 'depart'));
  }
  public function questionadd($department_id, $subject_id)
  {
    $subs  = CourseSubject::findOrFail($subject_id);
    $ques = $subs->QuestiSub()->where('subject_id', $subject_id)->get();

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.import', compact('subs', 'ques', 'depart'));
  }
  public function create($department_id, $subject_id)
  {
    $typequs = QuestionType::all();

    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $subs  = CourseSubject::findOrFail($subject_id);

    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.create', compact('subs', 'subject_id', 'typequs', 'lossen', 'depart'));
  }


  public function store(Request $request, $department_id, $subject_id)
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


    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);

    libxml_use_internal_errors(true);
    if (!file_exists(public_path('/upload/Que/ck/'))) {
      mkdir(public_path('/upload/Que/ck/'), 0755, true);
    }
    if ($request->has('question')) {
      $question = $request->question;
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $de_th->loadHTML(mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();
      }

      $ques->question = $question;
    }
    if ($request->has('choice1')) {
      $choice1 = $request->choice1;
      if (!empty($choice1)) {
        $choice_1 = new DOMDocument();
        $choice_1->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_1->loadHTML(mb_convert_encoding($choice1, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_1 = $choice_1->getElementsByTagName('img');

        foreach ($images_choice_1 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice1 = $choice_1->saveHTML();
      }

      $ques->choice1 = $choice1;
    }

    $questions = [];
    for ($i = 1; $i <= 10; $i++) {
      $question = "q$i";
      if ($request->$question) {
        $questions[] = $request->$question;
      }
    }

    $ques->choice1 .= !empty($questions) ?  implode(',', $questions) : '';


    if ($request->has('choice2')) {
      $choice2 = $request->choice2;
      if (!empty($choice1)) {
        $choice_2 = new DOMDocument();
        $choice_2->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_2->loadHTML(mb_convert_encoding($choice2, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_2 = $choice_2->getElementsByTagName('img');

        foreach ($images_choice_2 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice2 = $choice_2->saveHTML();
      }

      $ques->choice2 = $choice2;
    }
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

    if ($request->has('choice3')) {
      $choice3 = $request->choice3;
      if (!empty($choice3)) {
        $choice_3 = new DOMDocument();
        $choice_3->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_3->loadHTML(mb_convert_encoding($choice3, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_3 = $choice_3->getElementsByTagName('img');

        foreach ($images_choice_3 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice3 = $choice_3->saveHTML();
      }

      $ques->choice3 = $choice3;
    }

    $quesanss = [];
    for ($i = 1; $i <= 10; $i++) {
      $quesansKey = "ans$i";
      if ($request->$quesansKey) {
        $quesanss[] = $request->$quesansKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice3
    $ques->choice3 .= !empty($quesanss) ? implode(',', $quesanss) : '';

    if ($request->has('choice4')) {
      $choice4 = $request->choice4;
      if (!empty($choice4)) {
        $choice_4 = new DOMDocument();
        $choice_4->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_4->loadHTML(mb_convert_encoding($choice4, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_4 = $choice_4->getElementsByTagName('img');

        foreach ($images_choice_4 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice4 = $choice_4->saveHTML();
      }

      $ques->choice4 = $choice4;
    }


    $queskos = [];
    for ($i = 1; $i <= 10; $i++) {
      $queskook = "o$i";
      if ($request->$queskook) {
        $queskos[] = $request->$queskook;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice4
    $ques->choice4 .= !empty($queskos) ?  implode(',', $queskos) : '';

    $checkanswer = request('checkanswer');
    $ques->answer = json_encode($checkanswer);



    if ($request->has('choice5')) {
      $choice5 = $request->choice5;
      if (!empty($choice5)) {
        $choice_5 = new DOMDocument();
        $choice_5->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_5->loadHTML(mb_convert_encoding($choice5, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_5 = $choice_5->getElementsByTagName('img');

        foreach ($images_choice_5 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice5 = $choice_5->saveHTML();
      }

      $ques->choice5 = $choice5;
    }


    if ($request->has('choice6')) {
      $choice6 = $request->choice6;
      if (!empty($choice6)) {
        $choice_6 = new DOMDocument();
        $choice_6->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_6->loadHTML(mb_convert_encoding($choice6, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_6 = $choice_6->getElementsByTagName('img');

        foreach ($images_choice_6 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice6 = $choice_6->saveHTML();
      }

      $ques->choice6 = $choice6;
    }

    if ($request->has('choice7')) {
      $choice7 = $request->choice7;
      if (!empty($choice7)) {
        $choice_7 = new DOMDocument();
        $choice_7->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_7->loadHTML(mb_convert_encoding($choice7, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_7 = $choice_7->getElementsByTagName('img');

        foreach ($images_choice_7 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice7 = $choice_7->saveHTML();
      }

      $ques->choice7 = $choice7;
    }

    if ($request->has('choice8')) {
      $choice8 = $request->choice8;
      if (!empty($choice8)) {
        $choice_8 = new DOMDocument();
        $choice_8->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_8->loadHTML(mb_convert_encoding($choice8, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_8 = $choice_8->getElementsByTagName('img');

        foreach ($images_choice_8 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice8 = $choice_8->saveHTML();
      }

      $ques->choice8 = $choice8;
    }
    $ques->score = $request->score;
    $ques->numchoice = $request->numchoice;

    if ($request->has('explain')) {
      $explain = $request->explain;
      if (!empty($explain)) {
        $choice_explain = new DOMDocument();
        $choice_explain->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_explain->loadHTML(mb_convert_encoding($explain, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_explain = $choice_explain->getElementsByTagName('img');

        foreach ($images_choice_explain as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $explain = $choice_explain->saveHTML();
      }

      $ques->explain = $explain;
    }
    $ques->ordering = null;
    $ques->lesson_id = $request->lesson_id;
    $ques->subject_id = $subject_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', [$department_id, 'subject_id' => $subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
  }
  public function edit($department_id, $question_id)
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

  public function update(Request $request, $department_id, $question_id)
  {

    $ques = Question::findOrFail($question_id);
  
    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);
 
    libxml_use_internal_errors(true);
    if (!file_exists(public_path('/upload/Que/ck/'))) {
      mkdir(public_path('/upload/Que/ck/'), 0755, true);
    }
    if ($request->has('question')) {
      $question = $request->question;
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $de_th->loadHTML(mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();
      }

      $ques->question = $question;
    }
    if ($request->has('choice1')) {
      $choice1 = $request->choice1;
      if (!empty($choice1)) {
        $choice_1 = new DOMDocument();
        $choice_1->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_1->loadHTML(mb_convert_encoding($choice1, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_1 = $choice_1->getElementsByTagName('img');

        foreach ($images_choice_1 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice1 = $choice_1->saveHTML();
      }

      $ques->choice1 = $choice1;
    }



    $questions = [];
    for ($i = 1; $i <= 10; $i++) {
      $question = "q$i";
      if ($request->$question) {
        $questions[] = $request->$question;
      }
    }

    $ques->choice1 .= !empty($questions) ?  implode(',', $questions) : '';



    if ($request->has('choice2')) {
      $choice2 = $request->choice2;
      if (!empty($choice1)) {
        $choice_2 = new DOMDocument();
        $choice_2->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_2->loadHTML(mb_convert_encoding($choice2, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_2 = $choice_2->getElementsByTagName('img');

        foreach ($images_choice_2 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice2 = $choice_2->saveHTML();
      }

      $ques->choice2 = $choice2;
    }

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

if ($request->has('choice3')) {
      $choice3 = $request->choice3;
      if (!empty($choice3)) {
        $choice_3 = new DOMDocument();
        $choice_3->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_3->loadHTML(mb_convert_encoding($choice3, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_3 = $choice_3->getElementsByTagName('img');

        foreach ($images_choice_3 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice3 = $choice_3->saveHTML();
      }

      $ques->choice3 = $choice3;
    }

    $quesanss = [];
    for ($i = 1; $i <= 10; $i++) {
      $quesansKey = "ans$i";
      if ($request->$quesansKey) {
        $quesanss[] = $request->$quesansKey;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice3
    $ques->choice3 .= !empty($quesanss) ? implode(',', $quesanss) : '';


    if ($request->has('choice4')) {
      $choice4 = $request->choice4;
      if (!empty($choice4)) {
        $choice_4 = new DOMDocument();
        $choice_4->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_4->loadHTML(mb_convert_encoding($choice4, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_4 = $choice_4->getElementsByTagName('img');

        foreach ($images_choice_4 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice4 = $choice_4->saveHTML();
      }

      $ques->choice4 = $choice4;
    }


    $queskos = [];
    for ($i = 1; $i <= 10; $i++) {
      $queskook = "o$i";
      if ($request->$queskook) {
        $queskos[] = $request->$queskook;
      }
    }

    // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice4
    $ques->choice4 .= !empty($queskos) ?  implode(',', $queskos) : '';

  
    if ($request->has('choice5')) {
      $choice5 = $request->choice5;
      if (!empty($choice5)) {
        $choice_5 = new DOMDocument();
        $choice_5->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_5->loadHTML(mb_convert_encoding($choice5, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_5 = $choice_5->getElementsByTagName('img');

        foreach ($images_choice_5 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice5 = $choice_5->saveHTML();
      }

      $ques->choice5 = $choice5;
    }


    if ($request->has('choice6')) {
      $choice6 = $request->choice6;
      if (!empty($choice6)) {
        $choice_6 = new DOMDocument();
        $choice_6->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_6->loadHTML(mb_convert_encoding($choice6, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_6 = $choice_6->getElementsByTagName('img');

        foreach ($images_choice_6 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice6 = $choice_6->saveHTML();
      }

      $ques->choice6 = $choice6;
    }

    if ($request->has('choice7')) {
      $choice7 = $request->choice7;
      if (!empty($choice7)) {
        $choice_7 = new DOMDocument();
        $choice_7->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_7->loadHTML(mb_convert_encoding($choice7, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_7 = $choice_7->getElementsByTagName('img');

        foreach ($images_choice_7 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice7 = $choice_7->saveHTML();
      }

      $ques->choice7 = $choice7;
    }

    if ($request->has('choice8')) {
      $choice8 = $request->choice8;
      if (!empty($choice8)) {
        $choice_8 = new DOMDocument();
        $choice_8->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_8->loadHTML(mb_convert_encoding($choice8, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_8 = $choice_8->getElementsByTagName('img');

        foreach ($images_choice_8 as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $choice8 = $choice_8->saveHTML();
      }

      $ques->choice8 = $choice8;
    }


    if ($request->has('explain')) {
      $explain = $request->explain;
      if (!empty($explain)) {
        $choice_explain = new DOMDocument();
        $choice_explain->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $choice_explain->loadHTML(mb_convert_encoding($explain, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images_choice_explain = $choice_explain->getElementsByTagName('img');

        foreach ($images_choice_explain as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            file_put_contents(public_path() . $image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = asset($image_name);
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $explain = $choice_explain->saveHTML();
      }

      $ques->explain = $explain;
    }
    $ques->score = $request->score;
    $ques->numchoice = $request->numchoice;

    $checkanswer = request('checkanswer');
    $ques->answer = json_encode($checkanswer);

    $ques->ordering = null;
    $ques->lesson_id = $request->lesson_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', [$department_id, 'subject_id' => $ques->subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
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
