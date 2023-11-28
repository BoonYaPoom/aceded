<?php

namespace App\Http\Controllers;


use App\Models\CourseSubject;
use App\Models\CourseTeacher;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Survey;
use DOMDocument;
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
      
            'subject_code' => 'required|unique:course_subject',
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

        return redirect()->route('suppage', [ $department_id])->with('message', 'CourseSub บันทึกข้อมูลสำเร็จ');
    }

    public function destory($department_id,$subject_id)
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

        set_time_limit(0);
      
        if (!file_exists(public_path('/uplade'))) {
            mkdir(public_path('/uplade'), 0755, true);
        }

    
        if ($request->has('description_th')) {
            $description_th = $request->description_th;
            $decodedTextdescription_th = '';
            if (!empty($description_th)) {
                $des_th = new DOMDocument();
                $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $description_th = mb_convert_encoding($description_th, 'HTML-ENTITIES', 'UTF-8');
                $description_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $description_th);
                $des_th->loadHTML($description_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_use_internal_errors(true);
                $images_des_th = $des_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $description_th = $des_th->saveHTML();
                $decodedTextdescription_th = html_entity_decode($description_th, ENT_QUOTES, 'UTF-8');
            }

            $subs->description_th = $decodedTextdescription_th;
        }
        if ($request->has('description_en')) {
            $description_en = $request->description_en;
            $decodedTextdescription_en = '';
            if (!empty($description_en)) {
                $des_en = new DOMDocument();
                $des_en->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $description_en = mb_convert_encoding($description_en, 'HTML-ENTITIES', 'UTF-8');
                $description_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $description_en);
                $des_en->loadHTML($description_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_use_internal_errors(true);
                $images_des_en = $des_en->getElementsByTagName('img');

                // แปลงรูปภาพสำหรับเนื้อหาภาษาอังกฤษ
                foreach ($images_des_en as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $description_en = $des_en->saveHTML();
                $decodedTextdescription_en = html_entity_decode($description_en, ENT_QUOTES, 'UTF-8');
            }

            $subs->description_en = $decodedTextdescription_en;
        }
        if ($request->has('objectives_th')) {
            $objectives_th = $request->objectives_th;
            $decodedTextobjectives_th = '';
            if (!empty($objectives_th)) {
            $ob_th = new DOMDocument();
            $ob_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $objectives_th = mb_convert_encoding($objectives_th, 'HTML-ENTITIES', 'UTF-8');
            $objectives_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $objectives_th);
            $ob_th->loadHTML($objectives_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors(true);
            $images_ob_th = $ob_th->getElementsByTagName('img');

            foreach ($images_ob_th as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }
            $objectives_th = $ob_th->saveHTML();
            $decodedTextobjectives_th = html_entity_decode($objectives_th, ENT_QUOTES, 'UTF-8');
        }

            $subs->objectives_th = $decodedTextobjectives_th;
        }
        if ($request->has('objectives_en')) {
            $objectives_en = $request->objectives_en;
            $decodedTextobjectives_en = '';
            if (!empty($objectives_en)) {
            $ob_en = new DOMDocument();
            $ob_en->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $objectives_en = mb_convert_encoding($objectives_en, 'HTML-ENTITIES', 'UTF-8');
            $objectives_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $objectives_en);
            $ob_en->loadHTML($objectives_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors(true);
            $images_ob_en = $ob_en->getElementsByTagName('img');
            foreach ($images_ob_en as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }
            $objectives_en = $ob_en->saveHTML();
            $decodedTextobjectives_en = html_entity_decode($objectives_en, ENT_QUOTES, 'UTF-8');
        }
       
            $subs->objectives_en = $decodedTextobjectives_en;
        }
        if ($request->has('schedule_th')) {
            $schedule_th = $request->schedule_th;
            $decodedTextschedule_th = '';
            if (!empty($schedule_th)) {
            $qua_th = new DOMDocument();
            $qua_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $schedule_th = mb_convert_encoding($schedule_th, 'HTML-ENTITIES', 'UTF-8');
            $schedule_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $schedule_th);
            $qua_th->loadHTML($schedule_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                 libxml_use_internal_errors(true);
            $images_qua_th = $qua_th->getElementsByTagName('img');

            foreach ($images_qua_th as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }
            $schedule_th = $qua_th->saveHTML();
            $decodedTextschedule_th = html_entity_decode($schedule_th, ENT_QUOTES, 'UTF-8');
        }
     
            $subs->schedule_th = $decodedTextschedule_th;
        }
        if ($request->has('schedule_en')) {
            $schedule_en = $request->schedule_en;
            $decodedTextschedule_en = '';
            if (!empty($schedule_en)) {
            $qua_en = new DOMDocument();
            $qua_en->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $schedule_en = mb_convert_encoding($schedule_en, 'HTML-ENTITIES', 'UTF-8');
            $schedule_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $schedule_en);
            $qua_en->loadHTML($schedule_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
              libxml_use_internal_errors(true);
            $images_qua_en = $qua_en->getElementsByTagName('img');

            foreach ($images_qua_en as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }

            $schedule_en = $qua_en->saveHTML();
            $decodedTextschedule_en = html_entity_decode($schedule_en, ENT_QUOTES, 'UTF-8');
        }

            $subs->schedule_en = $decodedTextschedule_en;
        }
        if ($request->has('evaluation_th')) {
            $evaluation_th = $request->evaluation_th;
            $decodedTextevaluation_th = '';
            if (!empty($evaluation_th)) {
            $eva_th = new DOMDocument();
            $eva_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $evaluation_th = mb_convert_encoding($evaluation_th, 'HTML-ENTITIES', 'UTF-8');
            $evaluation_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $evaluation_th);
            $eva_th->loadHTML($evaluation_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors(true);
            $images_eva_th = $eva_th->getElementsByTagName('img');

            foreach ($images_eva_th as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }
            $evaluation_th = $eva_th->saveHTML();
            $decodedTextevaluation_th = html_entity_decode($evaluation_th, ENT_QUOTES, 'UTF-8');
        }

            $subs->evaluation_th = $decodedTextevaluation_th;
        }
        if ($request->has('evaluation_en')) {
            $evaluation_en = $request->evaluation_en;
            $decodedTextevaluation_en = '';
            if (!empty($evaluation_en)) {
            $eva_en = new DOMDocument();
            $eva_en->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $evaluation_en = mb_convert_encoding($evaluation_en, 'HTML-ENTITIES', 'UTF-8');
            $evaluation_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $evaluation_en);
            $eva_en->loadHTML($evaluation_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors(true);
            $images_eva_en = $eva_en->getElementsByTagName('img');

            foreach ($images_eva_en as $key => $img) {
                if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/uplade/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                }
            }
            $evaluation_en = $eva_en->saveHTML();
            $decodedTextevaluation_en = html_entity_decode($evaluation_en, ENT_QUOTES, 'UTF-8');
        }

            $subs->evaluation_en = $decodedTextevaluation_en;
        }
     
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
