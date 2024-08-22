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
use Illuminate\Support\Facades\Storage;
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
      $maxExamId = Exam::max('exam_id');
      $newExamId = $maxExamId + 1;
      $exams = new Exam;
      $exams->exam_id = $newExamId;
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
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }

    return redirect()->route('exampage', [$department_id, 'subject_id' => $subject_id])->with('message', 'Exam add successfully');
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
    return view('page.manage.sub.exam.edit', compact('exams', 'subs', 'ques', 'typequs', 'lossen', 'depart'));
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

    $maxquestionId = Question::max('question_id');
    $newquestionId = $maxquestionId + 1;
    $ques = new Question;
    $ques->question_id = $newquestionId;
    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);

    libxml_use_internal_errors(true);
    // if (!file_exists(public_path('/upload/Que/ck/'))) {
    //   mkdir(public_path('/upload/Que/ck/'), 0755, true);
    // }
    if (!Storage::disk('sftp')->exists('/upload/Que/ck/')) {
      Storage::disk('sftp')->makeDirectory('/upload/Que/ck/');
    }


    if ($request->has('question')) {
      $question = $request->question;
      $decodedTextquestion = '';
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; 
        $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
        $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
        $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png';
            Storage::disk('sftp')->put($image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();

        $decodedTextquestion = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
      }


      $ques->question = $decodedTextquestion;
    }
    if ($ques->question_type == 1) {

      if ($request->has('CHOICE1')) {
        $choice1 = $request->CHOICE1;
        $decodedTextchoice1 = '';

        if (!empty($choice1)) {
          $choice_1 = new DOMDocument();
          $choice_1->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice1 = mb_convert_encoding($choice1, 'HTML-ENTITIES', 'UTF-8');
          $choice1 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice1);
          $choice_1->loadHTML($choice1, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_1 = $choice_1->getElementsByTagName('img');

          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu1/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu1/');
          }
          foreach ($images_choice_1 as $key1 => $img1) {
            if (strpos($img1->getAttribute('src'), 'data:image/') === 0) {
              $data1 = base64_decode(explode(',', explode(';', $img1->getAttribute('src'))[1])[1]);
              $image_name1 = '/upload/Que/ck/qu1/' . time() . $key1 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name1, $data1);
              $img1->removeAttribute('src');
              $newImageUrl1 = env('URL_FILE_SFTP') . $image_name1;
              $img1->setAttribute('src', $newImageUrl1);
            }
          }
          $choice1 = $choice_1->saveHTML();
          $decodedTextchoice1 = html_entity_decode($choice1, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice1 = $decodedTextchoice1;
      }


      if ($request->has('CHOICE2')) {
        $choice2 = $request->CHOICE2;
        $decodedTextchoice2 = '';
        if (!empty($choice2)) {
          $choice_2 = new DOMDocument();
          $choice_2->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice2 = mb_convert_encoding($choice2, 'HTML-ENTITIES', 'UTF-8');
          $choice2 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice2);
          $choice_2->loadHTML($choice2, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_2 = $choice_2->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu2/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu2/');
          }
          foreach ($images_choice_2 as $key2 => $img2) {
            if (strpos($img2->getAttribute('src'), 'data:image/') === 0) {
              $data2 = base64_decode(explode(',', explode(';', $img2->getAttribute('src'))[1])[1]);
              $image_name2 = '/upload/Que/ck/qu2/' . time() . $key2 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name2, $data2);
              $img2->removeAttribute('src');
              $newImageUrl2 = env('URL_FILE_SFTP') . $image_name2;
              $img2->setAttribute('src', $newImageUrl2);
            }
          }
          $choice2 = $choice_2->saveHTML();
          $decodedTextchoice2 = html_entity_decode($choice2, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice2 = $decodedTextchoice2;
      }

      if ($request->has('CHOICE3')) {
        $choice3 = $request->CHOICE3;
        $decodedTextchoice3 = '';
        if (!empty($choice3)) {
          $choice_3 = new DOMDocument();
          $choice_3->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice3 = mb_convert_encoding($choice3, 'HTML-ENTITIES', 'UTF-8');
          $choice3 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice3);
          $choice_3->loadHTML($choice3, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_3 = $choice_3->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu3/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu3/');
          }
          foreach ($images_choice_3 as $key3 => $img3) {
            if (strpos($img3->getAttribute('src'), 'data:image/') === 0) {
              $data3 = base64_decode(explode(',', explode(';', $img3->getAttribute('src'))[1])[1]);
              $image_name3 = '/upload/Que/ck/qu3/' . time() . $key3 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name3, $data3);
              $img3->removeAttribute('src');
              $newImageUrl3 = env('URL_FILE_SFTP') . $image_name3;
              $img3->setAttribute('src', $newImageUrl3);
            }
          }
          $choice3 = $choice_3->saveHTML();
          $decodedTextchoice3 = html_entity_decode($choice3, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice3 = $decodedTextchoice3;
      }



      if ($request->has('CHOICE4')) {
        $choice4 = $request->CHOICE4;
        $decodedTextchoice4 = '';
        if (!empty($choice4)) {
          $choice_4 = new DOMDocument();

          $choice_4->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice4 = mb_convert_encoding($choice4, 'HTML-ENTITIES', 'UTF-8');
          $choice4 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice4);
          $choice_4->loadHTML($choice4, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_4 = $choice_4->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu4/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu4/');
          }
          foreach ($images_choice_4 as $key4 => $img4) {
            if (strpos($img4->getAttribute('src'), 'data:image/') === 0) {
              $data4 = base64_decode(explode(',', explode(';', $img4->getAttribute('src'))[1])[1]);
              $image_name4 = '/upload/Que/ck/qu4/' . time() . $key4 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name4, $data4);
              $img4->removeAttribute('src');
              $newImageUrl4 = env('URL_FILE_SFTP') . $image_name4;
              $img4->setAttribute('src', $newImageUrl4);
            }
          }
          $choice4 = $choice_4->saveHTML();
          $decodedTextchoice4 = html_entity_decode($choice4, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice4 = $decodedTextchoice4;
      }



      if ($request->has('CHOICE5')) {
        $choice5 = $request->CHOICE5;
        $decodedTextchoice5 = '';
        if (!empty($choice5)) {
          $choice_5 = new DOMDocument();
          $choice_5->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice5 = mb_convert_encoding($choice5, 'HTML-ENTITIES', 'UTF-8');
          $choice5 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice5);
          $choice_5->loadHTML($choice5, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_5 = $choice_5->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu5/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu5/');
          }
          foreach ($images_choice_5 as $key5 => $img5) {
            if (strpos($img5->getAttribute('src'), 'data:image/') === 0) {
              $data5 = base64_decode(explode(',', explode(';', $img5->getAttribute('src'))[1])[1]);
              $image_name5 = '/upload/Que/ck/qu5/' . time() . $key5 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name5, $data5);
              $img5->removeAttribute('src');
              $newImageUrl5 = env('URL_FILE_SFTP') . $image_name5;
              $img5->setAttribute('src', $newImageUrl5);
            }
          }
          $choice5 = $choice_5->saveHTML();
          $decodedTextchoice5 = html_entity_decode($choice5, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice5 = $decodedTextchoice5;
      }
      if ($request->has('CHOICE6')) {
        $choice6 = $request->CHOICE6;
        $decodedTextchoice6 = '';
        if (!empty($choice6)) {
          $choice_6 = new DOMDocument();
          $choice_6->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice6 = mb_convert_encoding($choice6, 'HTML-ENTITIES', 'UTF-8');
          $choice6 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice6);
          $choice_6->loadHTML($choice6, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_6 = $choice_6->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu6/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu6/');
          }
          foreach ($images_choice_6 as $key6 => $img6) {
            if (strpos($img6->getAttribute('src'), 'data:image/') === 0) {
              $data6 = base64_decode(explode(',', explode(';', $img6->getAttribute('src'))[1])[1]);
              $image_name6 = '/upload/Que/ck/qu6/' . time() . $key6 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name6, $data6);
              $img6->removeAttribute('src');
              $newImageUrl6 = env('URL_FILE_SFTP') . $image_name6;
              $img6->setAttribute('src', $newImageUrl6);
            }
          }
          $choice6 = $choice_6->saveHTML();
          $decodedTextchoice6 = html_entity_decode($choice6, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice6 = $decodedTextchoice6;
      }

      if ($request->has('choice7')) {
        $choice7 = $request->CHOICE7;
        $decodedTextchoice7 = '';
        if (!empty($choice7)) {
          $choice_7 = new DOMDocument();
          $choice_7->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice7 = mb_convert_encoding($choice7, 'HTML-ENTITIES', 'UTF-8');
          $choice7 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice7);
          $choice_7->loadHTML($choice7, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_7 = $choice_7->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu7/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu7/');
          }
          foreach ($images_choice_7 as $key7 => $img7) {
            if (strpos($img7->getAttribute('src'), 'data:image/') === 0) {
              $data7 = base64_decode(explode(',', explode(';', $img7->getAttribute('src'))[1])[1]);
              $image_name7 = '/upload/Que/ck/qu7/' . time() . $key7 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name7, $data7);
              $img7->removeAttribute('src');
              $newImageUrl7 = env('URL_FILE_SFTP') . $image_name7;
              $img7->setAttribute('src', $newImageUrl7);
            }
          }
          $choice7 = $choice_7->saveHTML();
          $decodedTextchoice7 = html_entity_decode($choice7, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice7 = $decodedTextchoice7;
      }

      if ($request->has('CHOICE8')) {
        $choice8 = $request->CHOICE8;
        $decodedTextchoice8 = '';
        if (!empty($choice8)) {
          $choice_8 = new DOMDocument();
          $choice_8->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice8 = mb_convert_encoding($choice8, 'HTML-ENTITIES', 'UTF-8');
          $choice8 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice8);
          $choice_8->loadHTML($choice8, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_8 = $choice_8->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu8/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu8/');
          }
          foreach ($images_choice_8 as $key8 => $img8) {
            if (strpos($img8->getAttribute('src'), 'data:image/') === 0) {
              $data8 = base64_decode(explode(',', explode(';', $img8->getAttribute('src'))[1])[1]);
              $image_name8 = '/upload/Que/ck/qu8/' . time() . $key8 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name8, $data8);
              $img8->removeAttribute('src');
              $newImageUrl8 = env('URL_FILE_SFTP') . $image_name8;
              $img8->setAttribute('src', $newImageUrl8);
            }
          }
          $choice8 = $choice_8->saveHTML();
          $decodedTextchoice8 = html_entity_decode($choice8, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice8 = $decodedTextchoice8;
      }
      $checkanswer = request('checkanswer');
      $ques->answer = json_encode($checkanswer);

      $ques->numchoice = $request->numchoice;
    }
    if ($ques->question_type == 4) {

      $questions = [];
      for ($i = 1; $i <= 10; $i++) {
        $question = "q$i";
        if ($request->$question) {
          $questions[] = $request->$question;
        }
      }
      

      $ques->choice1 .= !empty($questions) ?  implode(',', $questions) : '';



      $coluques = [];
      for ($i = 1; $i <= 10; $i++) {
        $coluquesKey  = "c$i";
        if ($request->$coluquesKey) {
          $coluques[] = $request->$coluquesKey;
        }
      }

      // ต่อข้อมูลตัวเลือกใหม่ไปยัง choice2
      $ques->choice2 .= !empty($coluques) ?  implode(',', $coluques) : '';



      $quesanss = [];

      for ($i = 1; $i <= 10; $i++) {
        $quesansKey = "ans$i";
        if ($request->$quesansKey) {
          $quesanss[] = $request->$quesansKey;
        }
      }

      $ques->answer = json_encode(explode(',', implode(',', $quesanss)));

      $ques->numchoice = 2;
    }
    if ($ques->question_type == 5) {
      $nonNullChoicesCount = 0;
      $nonNullChoicesIndices = [];
      for ($i = 1; $i <= 8; $i++) {
        $choiceKey = "choice$i";
        $choiceValue = $request->input($choiceKey);
        $ques->$choiceKey = $choiceValue;

        if ($choiceValue !== null) {
          $nonNullChoicesCount++;
          $nonNullChoicesIndices[] = $i;
        }
        shuffle($nonNullChoicesIndices);

        $nonNullChoicesAsString = array_map('strval', $nonNullChoicesIndices);
        
      }


      $ques->answer = json_encode($nonNullChoicesAsString);
      $ques->numchoice = $nonNullChoicesCount;
    }
  

    if ($request->has('explain')) {
      $explain = $request->explain;
      $decodedTextexplain = '';
      if (!empty($explain)) {
        $choice_explain = new DOMDocument();
        $choice_explain->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $explain = mb_convert_encoding($explain, 'HTML-ENTITIES', 'UTF-8');
        $explain = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $explain);
        $choice_explain->loadHTML($explain, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images_choice_explain = $choice_explain->getElementsByTagName('img');
        if (!Storage::disk('sftp')->exists('/upload/Que/ck/exp/')) {
          Storage::disk('sftp')->makeDirectory('/upload/Que/ck/exp/');
        }
        foreach ($images_choice_explain as $exp => $imgexp) {
          if (strpos($imgexp->getAttribute('src'), 'data:image/') === 0) {
            $dataexp = base64_decode(explode(',', explode(';', $imgexp->getAttribute('src'))[1])[1]);
            $image_nameexp = '/upload/Que/ck/exp/' . time() . $exp . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_nameexp, $dataexp);
            $imgexp->removeAttribute('src');
            $newImageUrlexp = env('URL_FILE_SFTP') . $image_nameexp;
            $imgexp->setAttribute('src', $newImageUrlexp);
          }
        }
        $explain = $choice_explain->saveHTML();
        $decodedTextexplain = html_entity_decode($explain, ENT_QUOTES, 'UTF-8');
      }

      $ques->explain = $decodedTextexplain;
    }

    $ques->score = $request->score;



    $ques->lesson_id = $request->lesson_id;
    $ques->subject_id = $subject_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', [$department_id, 'subject_id' => $subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
  }
  public function edit($department_id, $subject_id, $question_id)
  {
    $ques  = Question::findOrFail($question_id);
    $typequs = QuestionType::all();
    $subject_id = $ques->subject_id;
    $lossen = CourseLesson::where('subject_id', $subject_id)->get();
    $subject_id =  $ques->subject_id;
    $subs = CourseSubject::findOrFail($subject_id);
    $department_id =   $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.exam.pageexam.edit', compact('typequs', 'lossen', 'ques', 'depart', 'subs'));
  }

  public function update(Request $request, $department_id, $subject_id, $question_id)
  {

    $ques = Question::findOrFail($question_id);

    $ques->question_type = $request->question_type;
    $ques->question_status = $request->input('question_status', 0);

    libxml_use_internal_errors(true);
    // if (!file_exists(public_path('/upload/Que/ck/'))) {
    //   mkdir(public_path('/upload/Que/ck/'), 0755, true);
    // }

    if (!Storage::disk('sftp')->exists('/upload/Que/ck/')) {
      Storage::disk('sftp')->makeDirectory('/upload/Que/ck/');
    }

    if ($request->has('question')) {
      $question = $request->question;
      $decodedTextquestion = '';
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
        $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
        $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/Que/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();

        $decodedTextquestion = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
      }

      dd($decodedTextquestion);
      $ques->question = $decodedTextquestion;
    }
    if ($ques->question_type == 5) {
      $ques->numchoice = null;
      $nonNullChoicesCount = 0;
      $nonNullChoicesIndices = [];
      for ($i = 1; $i <= 8; $i++) {
        $choiceKey = "choice$i";
        $choiceValue = $request->input($choiceKey);
        $ques->$choiceKey = $choiceValue;

        if ($choiceValue !== null) {
          $nonNullChoicesCount++;
          $nonNullChoicesIndices[] = $i;
        }
        shuffle($nonNullChoicesIndices);

        $nonNullChoicesAsString = array_map('strval', $nonNullChoicesIndices);
        
      }


      $ques->answer = json_encode($nonNullChoicesAsString);
      $ques->numchoice = $nonNullChoicesCount;
    }


    if ($ques->question_type == 4) {

      $questionschoice1 = [];
      for ($i = 1; $i <= 10; $i++) {
        $question1 = "q$i";
        if ($request->$question1) {
          $questionschoice1[] = $request->$question1;
        }
      }

      $ques->choice1 = implode(',', $questionschoice1);


      $coluques = [];
      for ($i = 1; $i <= 10; $i++) {
        $coluquesKey  = "c$i";
        if ($request->$coluquesKey) {
          $coluques[] = $request->$coluquesKey;
        }
      }


      $ques->choice2 = implode(',', $coluques);

      $answers = [];

      for ($i = 1; $i <= 10; $i++) {
        $quesansKey = "ans$i";
        $checkanswer = request($quesansKey);

        if ($checkanswer !== "0") {
          $answers[] = $checkanswer;
        }
      }

      $ques->answer = json_encode($answers);
    }
    if ($ques->question_type == 1) {



      if ($request->has('CHOICE1')) {
        $choice1 = $request->CHOICE1;
        $decodedTextchoice1 = '';
        if (!empty($choice1)) {
          $choice_1 = new DOMDocument();
          $choice_1->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice1 = mb_convert_encoding($choice1, 'HTML-ENTITIES', 'UTF-8');
          $choice1 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice1);
          $choice_1->loadHTML($choice1, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_1 = $choice_1->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu1/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu1/');
          }
          
          foreach ($images_choice_1 as $key1 => $img1) {
            if (strpos($img1->getAttribute('src'), 'data:image/') === 0) {
              $data1 = base64_decode(explode(',', explode(';', $img1->getAttribute('src'))[1])[1]);
              $image_name1 = '/upload/Que/ck/qu1/' . time() . $key1 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name1, $data1);
              $img1->removeAttribute('src');
              $newImageUrl1 = env('URL_FILE_SFTP') . $image_name1;
              $img1->setAttribute('src', $newImageUrl1);
            }
          }
          $choice1 = $choice_1->saveHTML();

          $decodedTextchoice1 = html_entity_decode($choice1, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice1 = $decodedTextchoice1;
      }


      if ($request->has('CHOICE2')) {
        $choice2 = $request->CHOICE2;
        $decodedTextchoice2 = '';
        if (!empty($choice2)) {
          $choice_2 = new DOMDocument();
          $choice_2->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice2 = mb_convert_encoding($choice2, 'HTML-ENTITIES', 'UTF-8');
          $choice2 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice2);
          $choice_2->loadHTML($choice2, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_2 = $choice_2->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu2/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu2/');
          }
       
          foreach ($images_choice_2 as $key2 => $img2) {
            if (strpos($img2->getAttribute('src'), 'data:image/') === 0) {
              $data2 = base64_decode(explode(',', explode(';', $img2->getAttribute('src'))[1])[1]);
              $image_name2 = '/upload/Que/ck/qu2/' . time() . $key2 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name2, $data2);
              $img2->removeAttribute('src');
              $newImageUrl2 = env('URL_FILE_SFTP') . $image_name2;
              $img2->setAttribute('src', $newImageUrl2);
            }
          }
          $choice2 = $choice_2->saveHTML();

          $decodedTextchoice2 = html_entity_decode($choice2, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice2 = $decodedTextchoice2;
      }

      if ($request->has('CHOICE3')) {
        $choice3 = $request->CHOICE3;
        $decodedTextchoice3 = '';
        if (!empty($choice3)) {
          $choice_3 = new DOMDocument();
          $choice_3->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice3 = mb_convert_encoding($choice3, 'HTML-ENTITIES', 'UTF-8');
          $choice3 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice3);
          $choice_3->loadHTML($choice3, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_3 = $choice_3->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu3/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu3/');
          }
          foreach ($images_choice_3 as $key3 => $img3) {
            if (strpos($img3->getAttribute('src'), 'data:image/') === 0) {
              $data3 = base64_decode(explode(',', explode(';', $img3->getAttribute('src'))[1])[1]);
              $image_name3 = '/upload/Que/ck/qu3/' . time() . $key3 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name3, $data3);
              $img3->removeAttribute('src');
              $newImageUrl3 = env('URL_FILE_SFTP') . $image_name3;
              $img3->setAttribute('src', $newImageUrl3);
            }
          }
          $choice3 = $choice_3->saveHTML();

          $decodedTextchoice3 = html_entity_decode($choice3, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice3 = $decodedTextchoice3;
      }



      if ($request->has('CHOICE4')) {
        $choice4 = $request->CHOICE4;
        $decodedTextchoice4 = '';
        if (!empty($choice4)) {
          $choice_4 = new DOMDocument();
          $choice_4->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice4 = mb_convert_encoding($choice4, 'HTML-ENTITIES', 'UTF-8');
          $choice4 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice4);
          $choice_4->loadHTML($choice4, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_4 = $choice_4->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu4/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu4/');
          }
          foreach ($images_choice_4 as $key4 => $img4) {
            if (strpos($img4->getAttribute('src'), 'data:image/') === 0) {
              $data4 = base64_decode(explode(',', explode(';', $img4->getAttribute('src'))[1])[1]);
              $image_name4 = '/upload/Que/ck/qu4/' . time() . $key4 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name4, $data4);
              $img4->removeAttribute('src');
              $newImageUrl4 = env('URL_FILE_SFTP') . $image_name4;
              $img4->setAttribute('src', $newImageUrl4);
            }
          }
          $choice4 = $choice_4->saveHTML();

          $decodedTextchoice4 = html_entity_decode($choice4, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice4 = $decodedTextchoice4;
      }




      if ($request->has('CHOICE5')) {
        $choice5 = $request->CHOICE5;
        $decodedTextchoice5 = '';
        if (!empty($choice5)) {
          $choice_5 = new DOMDocument();
          $choice_5->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice5 = mb_convert_encoding($choice5, 'HTML-ENTITIES', 'UTF-8');
          $choice5 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice5);
          $choice_5->loadHTML($choice5, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_5 = $choice_5->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu5/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu5/');
          }
          foreach ($images_choice_5 as $key5 => $img5) {
            if (strpos($img5->getAttribute('src'), 'data:image/') === 0) {
              $data5 = base64_decode(explode(',', explode(';', $img5->getAttribute('src'))[1])[1]);
              $image_name5 = '/upload/Que/ck/qu5/' . time() . $key5 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name5, $data5);
              $img5->removeAttribute('src');
              $newImageUrl5 = env('URL_FILE_SFTP') . $image_name5;
              $img5->setAttribute('src', $newImageUrl5);
            }
          }
          $choice5 = $choice_5->saveHTML();

          $decodedTextchoice5 = html_entity_decode($choice5, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice5 = $decodedTextchoice5;
      }

      if ($request->has('CHOICE6')) {
        $choice6 = $request->CHOICE6;
        $decodedTextchoice6 = '';
        if (!empty($choice6)) {
          $choice_6 = new DOMDocument();
          $choice_6->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice6 = mb_convert_encoding($choice6, 'HTML-ENTITIES', 'UTF-8');
          $choice6 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice6);
          $choice_6->loadHTML($choice6, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_6 = $choice_6->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu6/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu6/');
          }
          foreach ($images_choice_6 as $key6 => $img6) {
            if (strpos($img6->getAttribute('src'), 'data:image/') === 0) {
              $data6 = base64_decode(explode(',', explode(';', $img6->getAttribute('src'))[1])[1]);
              $image_name6 = '/upload/Que/ck/qu6/' . time() . $key6 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name6, $data6);
              $img6->removeAttribute('src');
              $newImageUrl6 = env('URL_FILE_SFTP') . $image_name6;
              $img6->setAttribute('src', $newImageUrl6);
            }
          }
          $choice6 = $choice_6->saveHTML();

          $decodedTextchoice6 = html_entity_decode($choice6, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice6 = $decodedTextchoice6;
      }

      if ($request->has('CHOICE7')) {
        $choice7 = $request->CHOICE7;
        $decodedTextchoice7 = '';
        if (!empty($choice7)) {
          $choice_7 = new DOMDocument();
          $choice_7->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice7 = mb_convert_encoding($choice7, 'HTML-ENTITIES', 'UTF-8');
          $choice7 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice7);
          $choice_7->loadHTML($choice7, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_7 = $choice_7->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu7/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu7/');
          }
          foreach ($images_choice_7 as $key7 => $img7) {
            if (strpos($img7->getAttribute('src'), 'data:image/') === 0) {
              $data7 = base64_decode(explode(',', explode(';', $img7->getAttribute('src'))[1])[1]);
              $image_name7 = '/upload/Que/ck/qu7/' . time() . $key7 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name7, $data7);
              $img7->removeAttribute('src');
              $newImageUrl7 = env('URL_FILE_SFTP') . $image_name7;
              $img7->setAttribute('src', $newImageUrl7);
            }
          }
          $choice7 = $choice_7->saveHTML();

          $decodedTextchoice7 = html_entity_decode($choice7, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice7 = $decodedTextchoice7;
      }

      if ($request->has('CHOICE8')) {
        $choice8 = $request->CHOICE8;
        $decodedTextchoice8 = '';
        if (!empty($choice8)) {
          $choice_8 = new DOMDocument();
          $choice_8->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $choice8 = mb_convert_encoding($choice8, 'HTML-ENTITIES', 'UTF-8');
          $choice8 = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $choice8);
          $choice_8->loadHTML($choice8, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images_choice_8 = $choice_8->getElementsByTagName('img');
          if (!Storage::disk('sftp')->exists('/upload/Que/ck/qu8/')) {
            Storage::disk('sftp')->makeDirectory('/upload/Que/ck/qu8/');
          }
          foreach ($images_choice_8 as $key8 => $img8) {
            if (strpos($img8->getAttribute('src'), 'data:image/') === 0) {
              $data8 = base64_decode(explode(',', explode(';', $img8->getAttribute('src'))[1])[1]);
              $image_name8 = '/upload/Que/ck/' . time() . $key8 . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name8, $data8);
              $img8->removeAttribute('src');
              $newImageUrl8 = env('URL_FILE_SFTP') . $image_name8;
              $img8->setAttribute('src', $newImageUrl8);
            }
          }
          $choice8 = $choice_8->saveHTML();
          $decodedTextchoice8 = html_entity_decode($choice8, ENT_QUOTES, 'UTF-8');
        }

        $ques->choice8 = $decodedTextchoice8;
      }
      $checkanswer = request('checkanswer');
      $ques->answer = json_encode($checkanswer);
      $ques->numchoice = $request->numchoice;
    }

    if ($request->has('explain')) {
      $explain = $request->explain;
      $decodedTextexplain = '';
      if (!empty($explain)) {
        $choice_explain = new DOMDocument();
        $choice_explain->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $explain = mb_convert_encoding($explain, 'HTML-ENTITIES', 'UTF-8');
        $explain = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $explain);
        $choice_explain->loadHTML($explain, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images_choice_explain = $choice_explain->getElementsByTagName('img');
        if (!Storage::disk('sftp')->exists('/upload/Que/ck/exp/')) {
          Storage::disk('sftp')->makeDirectory('/upload/Que/ck/exp/');
        }
        
        foreach ($images_choice_explain as $exp => $imgexp) {
          if (strpos($imgexp->getAttribute('src'), 'data:image/') === 0) {
            $dataexp = base64_decode(explode(',', explode(';', $imgexp->getAttribute('src'))[1])[1]);
            $image_nameexp = '/upload/Que/ck/exp/' . time() . $exp . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_nameexp, $dataexp);
            $imgexp->removeAttribute('src');
            $newImageUrlexp = env('URL_FILE_SFTP') . $image_nameexp;
            $imgexp->setAttribute('src', $newImageUrlexp);
          }
        }

        $explain = $choice_explain->saveHTML();
        $decodedTextexplain = html_entity_decode($explain, ENT_QUOTES, 'UTF-8');
      }

      $ques->explain = $decodedTextexplain;
    }

    $ques->score = $request->score;


    $ques->ordering = null;
    $ques->lesson_id = $request->lesson_id;
    $ques->explainquestion = '';
    $ques->save();


    return redirect()->route('pagequess', [$department_id, $subject_id])->with('message', 'surveyreport บันทึกข้อมูลสำเร็จ');
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
