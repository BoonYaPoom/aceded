<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Survey;
use App\Models\SurveyQuestion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyQuestionController extends Controller
{
  public function questionpage($survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.index', compact('sur', 'surques', 'depart'));
  }
  public function reportpage($survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $respoe = $sur->surRes()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.reportpage.index', compact('sur', 'surques', 'respoe', 'depart'));
  }

  public function create($survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.create', compact('sur', 'depart'));
  }

  public function store(Request $request, $survey_id)
  {

    $request->validate([
      'question' => 'required',


    ]);
    try {
      $surques = new SurveyQuestion;

      $surques->question = $request->question;
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

      return response()->view('errors.500', [], 500);
    }
    return redirect()->route('questionpage', ['survey_id' => $survey_id])->with('message', 'surveyreport update successfully');
  }

  public function edit($question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);
    $survey_id     = $surques->survey_id;
    $sur = Survey::findOrFail($survey_id);
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manages.survey.surveyquestion.edit', ['surques' => $surques, 'sur' => $sur, 'depart' => $depart]);
  }

  public function update(Request $request, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);

    $surques->question = $request->question;
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
    return redirect()->route('questionpage', ['survey_id' => $surques->survey_id])->with('message', 'surveyreport update successfully');
  }


  //ด้านล่างข้อมูลของ Subject



  public function surveyreport($survey_id)
  {
    $sur  = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.index', compact('sur', 'surques', 'depart'));
  }
  public function reportpageSubject($survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $respoe = $sur->surRes()->where('survey_id', $survey_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.report', compact('sur', 'surques', 'respoe', 'depart'));
  }
  public function createreport($survey_id)
  {
    $sur = Survey::findOrFail($survey_id);
    $surques = $sur->surs()->where('survey_id', $survey_id)->get();
    $subject_id = $sur->subject_id;
    $subs  = CourseSubject::findOrFail($subject_id);
    $suracts = $subs->suyvs()->where('subject_id', $subject_id)->get();
    $department_id   = $sur->department_id;
    $depart = Department::findOrFail($department_id);
    return view('page.manage.sub.activitys.activcontent.survey.surveyreport.create', compact('sur', 'surques', 'subs', 'suracts', 'depart'));
  }




  public function savereport(Request $request, $survey_id)
  {
    $request->validate([
      'question' => 'required',
    ]);

    $surques = new SurveyQuestion;
    $surques->question = $request->question;
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


    return redirect()->route('surveyquestion', ['survey_id' => $survey_id])->with('message', 'surveyreport update successfully');
  }


  public function editreport($question_id)
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

  public function updatereport(Request $request, $question_id)
  {
    $surques = SurveyQuestion::findOrFail($question_id);
    $surques->question = $request->question;
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


    return redirect()->route('surveyquestion', ['survey_id' => $surques->survey_id])->with('message', 'surveyreport update successfully');
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
