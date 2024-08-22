<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SurveyQuestionController extends Controller
{
  public function questionpage($department_id, $survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();

    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.index', compact('sur', 'surques', 'depart'));
  }
  public function reportpage($department_id, $survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $respoe = $sur->surRes()->where('survey_id', $survey_id)->get();

    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.reportpage.index', compact('sur', 'surques', 'respoe', 'depart'));
  }

  public function create($department_id, $survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.create', compact('sur', 'depart'));
  }

  public function store(Request $request, $department_id, $survey_id)
  {

    $request->validate([
      'question' => 'required',


    ]);
    try {


      $maxquestion_id = Survey::max('question_id');
      $newquestion_id = $maxquestion_id + 1;
      $surques = new SurveyQuestion;
      $surques->question_id = $newquestion_id;
      // if (!file_exists(public_path('/upload/suyQue/ck/'))) {
      //   mkdir(public_path('/upload/suyQue/ck/'), 0755, true);
      // }
      if (!Storage::disk('sftp')->exists('/upload/suyQue/ck/')) {
        Storage::disk('sftp')->makeDirectory('/upload/suyQue/ck/');
      }
    
      if ($request->has('question')) {
        $question = $request->question;
        $decodedTextdetail_th = '';
        if (!empty($question)) {
          $de_th = new DOMDocument();
          $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
          $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
          $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
          $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          libxml_use_internal_errors(true);
          $images_des_th = $de_th->getElementsByTagName('img');

          foreach ($images_des_th as $key => $img) {
            if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
              $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
              $image_name = '/upload/suyQue/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
              Storage::disk('sftp')->put($image_name, $data);
              $img->removeAttribute('src');
              $newImageUrl = env('URL_FILE_SFTP') . $image_name;
              $img->setAttribute('src', $newImageUrl);
            }
          }
          $question = $de_th->saveHTML();
          $decodedTextdetail_th = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
        }

        $surques->question = $decodedTextdetail_th;
      }
      $surques->question_type = $request->question_type;
      $surques->question_status = $request->input('question_status', 0);
      $surques->opt = $request->input('opt', 0);

      // เพิ่ม if ในการบันทึก ถ้าเลือก question_type 2
      if ($request->question_type == 2) {
        $questions = [];
        for ($i = 1; $i <= 10; $i++) {
          $question = "q$i";
          if ($request->$question) {
            $questions[] = $request->$question;
          }
        }
        if (isset($surques)) {
          if (!empty($questions)) {
            $formattedQuestions = array_map(function ($question) {
              return '"' . $question . '"';
            }, $questions);

            $surques->choice1 = !empty($formattedQuestions) ? '[' . implode(',', $formattedQuestions) . ']' : '';
          }
        }
      } else {

        $surques->choice1 = $request->choice1;
      }

      if ($request->question_type == 2) {
        $ques = [];
        for ($i = 1; $i <= 10; $i++) {
          $que = "c$i";
          if ($request->$que) {
            $ques[] = $request->$que;
          }
        }


        if (isset($surques)) {
          if (!empty($ques)) {
            $formattedQ = array_map(function ($ques) {
              return '"' . $ques . '"';
            }, $ques);

            $surques->choice2 = !empty($formattedQ) ? '[' . implode(',', $formattedQ) . ']' : '';
          }
        }
      } else {
        $surques->choice2 = $request->choice2;
      }

      $surques->choice3 = $request->choice3;
      $surques->choice4 = $request->choice4;
      $surques->choice5 = $request->choice5;
      $surques->choice6 = $request->choice6;
      $surques->choice7 = $request->choice7;
      $surques->choice8 = $request->choice8;
      $surques->numchoice = $request->numchoice;
      $surques->ordering = null;
      $surques->survey_id = (int)$survey_id;
      $surques->subject_id = null;
      $surques->required = '';
      $surques->save();

      DB::commit();
    } catch (\Exception $e) {

      DB::rollBack();
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
    return redirect()->route('questionpage', [$department_id, 'survey_id' => $survey_id])->with('message', 'surveyreport update successfully');
  }

  public function edit($department_id, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);
    $survey_id     = $surques->survey_id;
    $sur = Survey::findOrFail($survey_id);
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.edit', ['surques' => $surques, 'sur' => $sur, 'depart' => $depart]);
  }

  public function update(Request $request, $department_id, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);


    libxml_use_internal_errors(true);
    // if (!file_exists(public_path('/upload/suyQue/ck/'))) {
    //   mkdir(public_path('/upload/suyQue/ck/'), 0755, true);
    // }
    if (!Storage::disk('sftp')->exists('/upload/suyQue/ck/')) {
      Storage::disk('sftp')->makeDirectory('/upload/suyQue/ck/');
    }
   
    if ($request->has('question')) {
      $question = $request->question;
      $decodedTextdetail_th = '';
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
        $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
        $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(true);
        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/suyQue/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();
        $decodedTextdetail_th = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
      }

      $surques->question = $decodedTextdetail_th;
    }
    $surques->question_type = $request->question_type;
    $surques->question_status = $request->input('question_status', 0);
    $surques->opt = $request->input('opt', 0);


    if ($request->question_type == 2) {
      $questions = [];
      for ($i = 1; $i <= 10; $i++) {
        $question = "q$i";
        if ($request->$question) {
          $questions[] = $request->$question;
        }
      }
      if (isset($surques)) {
        if (!empty($questions)) {
          $formattedQuestions = array_map(function ($question) {
            return '"' . $question . '"';
          }, $questions);

          $surques->choice1 = !empty($formattedQuestions) ? '[' . implode(',', $formattedQuestions) . ']' : '';
        }
      }
    } else {

      $surques->choice1 = $request->choice1;
    }

    // เพิ่ม if ในการบันทึก ถ้าเลือก question_type 2
    if ($request->question_type == 2) {
      $ques = [];
      for ($i = 1; $i <= 10; $i++) {
        $que = "c$i";
        if ($request->$que) {
          $ques[] = $request->$que;
        }
      }

      if (isset($surques)) {
        if (!empty($ques)) {
          $formattedQ = array_map(function ($ques) {
            return '"' . $ques . '"';
          }, $ques);

          $surques->choice2 = !empty($formattedQ) ? '[' . implode(',', $formattedQ) . ']' : '';
        }
      }
    } else {
      $surques->choice2 = $request->choice2;
    }

    $surques->choice3 = $request->choice3;
    $surques->choice4 = $request->choice4;
    $surques->choice5 = $request->choice5;
    $surques->choice6 = $request->choice6;
    $surques->choice7 = $request->choice7;
    $surques->choice8 = $request->choice8;
    $surques->numchoice = $request->numchoice;
    $surques->ordering = null;
    $surques->subject_id = null;
    $surques->required = '';
    $surques->save();
    return redirect()->route('questionpage', [$department_id, 'survey_id' => $surques->survey_id])->with('message', 'surveyreport update successfully');
  }


  //ด้านล่างข้อมูลของ Subject



  public function surveyreport($department_id, $subject_id, $survey_id)
  {
    $sur  = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    $subs  = CourseSubject::findOrFail($subject_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.index', compact('sur', 'subs', 'surques', 'depart'));
  }
  public function reportpageSubject($department_id, $subject_id, $survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $respoe = $sur->surRes()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $subs  = CourseSubject::findOrFail($subject_id);
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.report', compact('sur', 'subs', 'surques', 'respoe', 'depart'));
  }
  public function createreport($department_id, $subject_id, $survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $subject_id = $sur->subject_id;
    $subs  = CourseSubject::findOrFail($subject_id);
    $suracts = $subs->suyvs()->where('subject_id', $subject_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    $subs  = CourseSubject::findOrFail($subject_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.create', compact('sur', 'subs', 'surques', 'subs', 'suracts', 'depart'));
  }




  public function savereport(Request $request, $department_id, $subject_id, $survey_id)
  {
    $request->validate([
      'question' => 'required',
    ]);

    $maxquestion_id = Survey::max('question_id');
    $newquestion_id = $maxquestion_id + 1;
    $surques = new SurveyQuestion;
    $surques->question_id = $newquestion_id;

    libxml_use_internal_errors(true);
    // if (!file_exists(public_path('/upload/suyQue/Dp/ck/'))) {
    //   mkdir(public_path('/upload/suyQue/Dp/ck/'), 0755, true);
    // }
    if (!Storage::disk('sftp')->exists('/upload/suyQue/ck/')) {
      Storage::disk('sftp')->makeDirectory('/upload/suyQue/ck/');
    }
   
    if ($request->has('question')) {
      $question = $request->question;
      $decodedTextdetail_th = '';
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
        $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
        $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(true);
        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/suyQue/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();
        $decodedTextdetail_th = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
      }


      $surques->question = $decodedTextdetail_th;
    }
    $surques->question_type = $request->question_type;
    $surques->question_status = $request->input('question_status', 0);
    $surques->opt = $request->input('opt', 0);

    if ($request->question_type == 2) {
      $questions = [];
      for ($i = 1; $i <= 10; $i++) {
        $question = "q$i";
        if ($request->$question) {
          $questions[] = $request->$question;
        }
      }
      if (isset($surques)) {
        if (!empty($questions)) {
          $formattedQuestions = array_map(function ($question) {
            return '"' . $question . '"';
          }, $questions);

          $surques->choice1 = !empty($formattedQuestions) ? '[' . implode(',', $formattedQuestions) . ']' : '';
        }
      }
    } else {

      $surques->choice1 = $request->choice1;
    }

    // เพิ่ม if ในการบันทึก ถ้าเลือก question_type 2
    if ($request->question_type == 2) {
      $ques = [];
      for ($i = 1; $i <= 10; $i++) {
        $que = "c$i";
        if ($request->$que) {
          $ques[] = $request->$que;
        }
      }


      if (isset($surques)) {
        if (!empty($ques)) {
          $formattedQ = array_map(function ($ques) {
            return '"' . $ques . '"';
          }, $ques);

          $surques->choice2 = !empty($formattedQ) ? '[' . implode(',', $formattedQ) . ']' : '';
        }
      }
    } else {
      $surques->choice2 = $request->choice2;
    }


    $surques->choice3 = $request->choice3;
    $surques->choice4 = $request->choice4;
    $surques->choice5 = $request->choice5;
    $surques->choice6 = $request->choice6;
    $surques->choice7 = $request->choice7;
    $surques->choice8 = $request->choice8;
    $surques->numchoice = $request->numchoice;
    $surques->ordering = null;
    $surques->survey_id = (int)$survey_id;

    $surques->required = '';
    $surques->save();


    return redirect()->route('surveyquestion', [ $department_id,$subject_id,'survey_id' => $survey_id])->with('message', 'surveyreport update successfully');
  }


  public function editreport($department_id, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);
    $survey_id  = $surques->survey_id;
    $sur = Survey::findOrFail($survey_id);
    $subject_id   = $sur->subject_id;
    $subs = CourseSubject::findOrFail($subject_id);
    $department_id   = $subs->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.edit', compact('surques', 'subs', 'sur', 'depart'));
  }

  public function updatereport(Request $request, $department_id,$subject_id, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);

    libxml_use_internal_errors(true);
    // if (!file_exists(public_path('/upload/suyQue/Dp/ck/'))) {
    //   mkdir(public_path('/upload/suyQue/Dp/ck/'), 0755, true);
    // }
    if (!Storage::disk('sftp')->exists('/upload/suyQue/ck/')) {
      Storage::disk('sftp')->makeDirectory('/upload/suyQue/ck/');
    }
    
    if ($request->has('question')) {
      $question = $request->question;
      $decodedTextdetail_th = '';
      if (!empty($question)) {
        $de_th = new DOMDocument();
        $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
        $question = mb_convert_encoding($question, 'HTML-ENTITIES', 'UTF-8');
        $question = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $question);
        $de_th->loadHTML($question, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(true);
        $images_des_th = $de_th->getElementsByTagName('img');

        foreach ($images_des_th as $key => $img) {
          if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/suyQue/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
            Storage::disk('sftp')->put($image_name, $data);
            $img->removeAttribute('src');
            $newImageUrl = env('URL_FILE_SFTP') . $image_name;
            $img->setAttribute('src', $newImageUrl);
          }
        }
        $question = $de_th->saveHTML();
        $decodedTextdetail_th = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
      }

      $surques->question = $decodedTextdetail_th;
    }
    $surques->question_type = $request->question_type;
    $surques->question_status = $request->input('question_status', 0);
    $surques->opt = $request->input('opt', 0);
    // เพิ่ม if ในการบันทึก ถ้าเลือก question_type 2
    if ($request->question_type == 2) {
      $questions = [];
      for ($i = 1; $i <= 10; $i++) {
        $question = "q$i";
        if ($request->$question) {
          $questions[] = $request->$question;
        }
      }
      if (isset($surques)) {
        if (!empty($questions)) {
          $formattedQuestions = array_map(function ($question) {
            return '"' . $question . '"';
          }, $questions);

          $surques->choice1 = !empty($formattedQuestions) ? '[' . implode(',', $formattedQuestions) . ']' : '';
        }
      }
    } else {

      $surques->choice1 = $request->choice1;
    }


    if ($request->question_type == 2) {
      $ques = [];
      for ($i = 1; $i <= 10; $i++) {
        $que = "c$i";
        if ($request->$que) {
          $ques[] = $request->$que;
        }
      }


      if (isset($surques)) {
        if (!empty($ques)) {
          $formattedQ = array_map(function ($ques) {
            return '"' . $ques . '"';
          }, $ques);

          $surques->choice2 = !empty($formattedQ) ? '[' . implode(',', $formattedQ) . ']' : '';
        }
      }
    } else {
      $surques->choice2 = $request->choice2;
    }

    $surques->choice3 = $request->choice3;
    $surques->choice4 = $request->choice4;
    $surques->choice5 = $request->choice5;
    $surques->choice6 = $request->choice6;
    $surques->choice7 = $request->choice7;
    $surques->choice8 = $request->choice8;
    $surques->numchoice = $request->numchoice;
    $surques->ordering = null;


    $surques->required = '';
    $surques->save();


    return redirect()->route('surveyquestion', [$department_id, $subject_id, 'survey_id' => $surques->survey_id])->with('message', 'surveyreport update successfully');
  }
  public function destory($question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);

    $surques->delete();
    return redirect()->back()->with('message', 'surveyreport delete successfully');
  }
  public function changeStatus(Request $request)
  {
    $surques = SurveyQuestion::find($request->question_id);

    if ($surques) {
      $surques->question_status = $request->question_status;
      $surques->save();

      return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
    } else {
      return response()->json(['message' => 'ไม่พบข้อมูล links']);
    }
  }
}
