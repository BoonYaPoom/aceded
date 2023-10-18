<?php

namespace App\Http\Controllers;


use App\Models\CourseSubject;
use App\Models\CourseTeacher;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseSubjectController extends Controller
{
    public function suppage($department_id)
    {

        $depart  = Department::findOrFail($department_id);
        $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();

        return view('page.manage.sub.index', compact('subs', 'depart'));
    }
    public function create($department_id)
    {
        $depart  = Department::findOrFail($department_id);
        $users4 = $depart->UserDe()->where('department_id', $department_id)->get();
        return view('page.manage.sub.create', compact('depart', 'users4'));
    }

    public function store(Request $request, $department_id)
    {

        $validator = Validator::make($request->all(), [

            'subject_code' => 'required',
            'subject_th' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try {
            $subs = new CourseSubject;
            $subs->subject_code = $request->subject_code;
            $subs->subject_th = $request->subject_th;
            $subs->subject_en = $request->subject_en;
            $subs->learn_format = $request->input('learn_format', 0);
            $subs->evaluation = $request->input('evaluation', 0);
            $subs->checkscore = $request->checkscore;
            $selectedTeachers = $request->input('teacher', []);
            $teachers = implode(',', $selectedTeachers);
            $subs->teacher = $teachers;
            $subs->department_id = (int)$department_id;
            $subs->subject_status = $request->input('subject_status', 0);
            $subs->intro_th = '';
            $subs->intro_en = '';
            $subs->description_th = '';
            $subs->description_en = '';
            $subs->objectives_th = '';
            $subs->objectives_en = '';
            $subs->qualification_th = '';
            $subs->qualification_en = '';
            $subs->evaluation_th = '';
            $subs->evaluation_en = '';
            $subs->document_th = '';
            $subs->document_en = '';
            $subs->schedule_th = '';
            $subs->schedule_en = '';
            $subs->create_date = now();
            $subs->setting = null;
            $subs->permission = '';
            $subs->checktime  = 0;
            $subs->subject_approve  = 0;
            $subs->result_learn_th = null;
            $subs->result_learn_en = null;
            $subs->save();

      
        if ($request->hasFile('banner')) {
            $image_name = 'banner' . $subs->subject_id . '.' . $request->banner->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/SubBanner/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/SubBanner/' . $image_name), file_get_contents($request->banner));
                $subs->banner = 'upload/Subject/SubBanner/' .  'banner' . $subs->subject_id . '.' . $request->banner->getClientOriginalExtension();
                $subs->save();
            }
        } else {
            $image_name = '';
            $subs->banner = $image_name;
            $subs->save();
        }

        $selectedTeachers = $request->input('teacher', []);


        $Users4 = \App\Models\Users::all()->where('user_role', 3);
        foreach ($Users4 as $teacherId) {
            $teach = new CourseTeacher;
            $teach->user_id = $teacherId->user_id;

            if (in_array($teacherId->user_id, $selectedTeachers)) {
                $teach->teacher_status = 1;
            } else {
                $teach->teacher_status = 0;
            }

            $teach->subject_id = $subs->subject_id;
            $teach->save();
        }


        $exam1 = new Exam;
        $exam1->exam_th = 'แบบทดสอบก่อนเรียน';
        $exam1->exam_en = 'Pretest';
        $exam1->exam_type = 1;
        $exam1->exam_status  = 0;
        $exam1->exam_score  = 0;
        $exam1->exam_options  = null;
        $exam1->exam_select  = 1;
        $exam1->exam_data  = '';
        $exam1->maxtake  = 0;
        $exam1->showscore   = 1;
        $exam1->showanswer   = 0;
        $exam1->randomquestion   = 1;
        $exam1->randomchoice   = 0;
        $exam1->limitdatetime    = 0;
        $exam1->setdatetime    = '';
        $exam1->limittime    = 0;
        $exam1->settime   = '';
        $exam1->survey_before   = 0;
        $exam1->survey_after   = 0;
        $exam1->lesson_id    = 0;
        $exam1->perpage    = 0;
        $exam1->score_pass   = 50;
        $exam1->subject_id = $subs->subject_id;
        // ... กำหนดค่าอื่นๆที่ต้องการในตาราง 'exam'
        $exam1->save();

        // สร้างข้อมูลอัตโนมัติในตาราง 'exam' โดยมี examtype เป็น 2
        $exam2 = new Exam;
        $exam2->exam_th = 'แบบทดสอบหลังเรียน';
        $exam2->exam_en = 'Posttest';
        $exam2->exam_type = 2;
        $exam2->exam_status  = 0;
        $exam2->exam_score  = 0;
        $exam2->exam_options  = null;
        $exam2->exam_select  = 1;
        $exam2->exam_data  = '';
        $exam2->maxtake  = 0;
        $exam2->showscore   = 1;
        $exam2->showanswer   = 0;
        $exam2->randomquestion   = 1;
        $exam2->randomchoice   = 0;
        $exam2->limitdatetime    = 0;
        $exam2->setdatetime    = '';
        $exam2->limittime    = 0;
        $exam2->settime   = '';
        $exam2->survey_before   = 0;
        $exam2->survey_after   = 0;
        $exam2->lesson_id    = 0;
        $exam2->perpage    = 0;
        $exam2->score_pass   = 50;
        $exam2->subject_id = $subs->subject_id;
        // ... กำหนดค่าอื่นๆที่ต้องการในตาราง 'exam'
        $exam2->save();



        $sur = new Survey;
        $sur->survey_th = 'แบบสำรวจความคุ้มค่าหลักสูตร';
        $sur->survey_en = 'แบบสำรวจความคุ้มค่าหลักสูตร';
        $sur->detail_th = null;
        $sur->detail_en = null;
        $sur->survey_date = now();
        $sur->department_id = $subs->department_id;;

        $sur->survey_status = 0;
        $sur->survey_type = 1;
        $sur->recommended = null;
        $sur->class_id = null;
        $sur->cover = null;
        $sur->subject_id = $subs->subject_id;
        $sur->save();

        $sur1 = new Survey;
        $sur1->survey_th = 'แบบสำรวจความพึงพอใจหลักสูตร';
        $sur1->survey_en = 'แบบสำรวจความพึงพอใจหลักสูตร';
        $sur1->detail_th = null;
        $sur1->detail_en = null;
        $sur1->survey_date = now();
        $sur1->department_id = $subs->department_id;;
        $sur1->survey_status = 0;
        $sur1->survey_type = 2;
        $sur1->recommended = null;
        $sur1->class_id = null;
        $sur1->cover = null;
        $sur1->subject_id = $subs->subject_id;
        $sur1->save();

        DB::commit();
    } catch (\Exception $e) {

        DB::rollBack();

        return response()->view('error.error-500', [], 500);
    }
        return redirect()->route('suppage', ['department_id' => $department_id])->with('message', 'CourseSub บันทึกข้อมูลสำเร็จ');
    }




    public function edit($department_id,$subject_id)
    {
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id   = $subs->department_id;
        $depart = Department::findOrFail($department_id);
        $users4 = $depart->UserDe()->where('department_id', $department_id)->get();
        return view('page.manage.sub.edit', compact('subs', 'depart', 'users4'));
    }

    public function update(Request $request,$department_id, $subject_id)
    {
        $request->validate([

            'subject_code' => 'required',
            'subject_th' => 'required'

        ]);


        $subs = CourseSubject::findOrFail($subject_id);
        $subs->subject_code = $request->subject_code;
        $subs->subject_th = $request->subject_th;
        $subs->subject_en = $request->subject_en;


        $subs->learn_format = $request->input('learn_format', 0);
        $subs->evaluation = $request->input('evaluation', 0);
        $subs->checkscore = $request->checkscore;

        $selectedTeachers = $request->input('teacher', []);
        $teachers = implode(',', $selectedTeachers);
        $subs->teacher = $teachers;

        $subs->department_id = $request->input('department_id', 0);
        $subs->subject_status = $request->input('subject_status', 0);

        $subs->update_date = now();
        $subs->setting = null;
        $subs->permission = '';
        $subs->checktime  = 0;
        $subs->subject_approve  = 0;
        $subs->result_learn_th = null;
        $subs->result_learn_en = null;
        $subs->save();


        if ($request->hasFile('banner')) {
            $image_name = 'banner' . $subs->subject_id . '.' . $request->banner->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/SubBanner/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/SubBanner/' . $image_name), file_get_contents($request->banner));
                $subs->banner = 'upload/Subject/SubBanner/' .  'banner' . $subs->subject_id . '.' . $request->banner->getClientOriginalExtension();
                $subs->save();
            }
        }

        return redirect()->route('suppage', ['department_id' => $subs->department_id])->with('message', 'CourseSub บันทึกข้อมูลสำเร็จ');
    }

    public function destory($subject_id)
    {
        $subs = CourseSubject::findOrFail($subject_id);
        $subs->subjs()->delete();
        $subs->delete();
        return redirect()->back()->with('message', 'CourseSub ลบข้อมูลสำเร็จ');
    }

    public function editdetailsub($department_id,$subject_id)
    {
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id   = $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.subjectdetail.subjectdetail', compact('subs', 'depart'));
    }


    public function updatedetail(Request $request,$department_id, $subject_id)
    {



        $subs = CourseSubject::findOrFail($subject_id);

        $subs->description_th = $request->description_th;
        $subs->description_en = $request->description_en;
        $subs->objectives_th = $request->objectives_th;
        $subs->objectives_en = $request->objectives_en;

        $subs->evaluation_th = $request->evaluation_th;
        $subs->evaluation_en = $request->evaluation_en;
        $subs->schedule_th = $request->schedule_th;
        $subs->schedule_en = $request->schedule_en;
        $subs->create_date = now();
        $subs->setting = null;
        $subs->permission = '';
        $subs->update_date = now();
        $subs->save();


        return redirect()->route('editdetailsub', [$department_id,'subject_id' => $subs->subject_id])->with('message', 'Detail บันทึกข้อมูลสำเร็จ');
    }

    public function changeStatus(Request $request)
    {
        $subs = CourseSubject::find($request->subject_id);

        if ($subs) {
            $subs->subject_status = $request->subject_status;
            $subs->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล CourseSubject']);
        }
    }
}
