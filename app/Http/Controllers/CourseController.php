<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseGroup;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Grade;
use App\Models\PersonType;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function courpag($department_id, $group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);
        $cour = $courses->group()->where('group_id', $group_id)->get();
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        return view('page.manage.group.co.index', compact('courses', 'cour', 'depart'));
    }

    public function create($department_id, $group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);

        $pertype = PersonType::all();

        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();
        return view('page.manage.group.co.create', compact('courses', 'subs', 'pertype', 'depart'));
    }

    public function store(Request $request, $department_id, $group_id)
    {


        $validator = Validator::make($request->all(), [
            'course_code' => 'required',
            'course_th' => 'required',
            'templete_certificate' => 'required'

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }

        $code = Course::generateCourseCode($group_id);
        $group = CourseGroup::find($group_id);
        $department_id = $group->department_id;
        $department = Department::find($department_id);
        $departmentId = $department->name_short_en;
        $codes = $departmentId . str_pad($code, 3, '0', STR_PAD_LEFT);
        $cour = new Course;
        $cour->course_code =  $codes;
        $cour->course_th = $request->course_th;
        $cour->course_en = $request->course_en;

        $cour->group_id = (int)$group_id;
        $cour->levels = 0;
        $selectedsubject = $request->input('subject', []);
        $subjData = array_map('strval', $selectedsubject);
        $subj = json_encode($subjData);
        $cour->subject = $subj;
        $cour->recommended = $request->input('recommended', 0);
        $cour->intro_th = null;
        $cour->intro_en = null;
        $cour->description_th = null;
        $cour->description_en = null;
        $cour->objectives_th = null;
        $cour->objectives_en = null;
        $cour->qualification_th = null;
        $cour->qualification_en = null;
        $cour->evaluation_th = null;
        $cour->evaluation_en = null;
        $cour->document_th = null;
        $cour->document_en = null;
        $cour->schedule_th = null;
        $cour->schedule_en = null;
        $cour->evaluation = $request->evaluation;
        $cour->courseformat = $request->courseformat;
        $cour->learnday = $request->learnday;
        $cour->lesson_type = $request->lesson_type;
        $cour->age = $request->age;
        $cour->agework = $request->agework;
        $selectedperson_type = $request->input('person_type', []);
        $convertedData = array_map('strval', $selectedperson_type);
        $result = json_encode($convertedData);
        $cour->person_type = $result;
        $cour->position = 0;
        $cour->position_type = null;
        $cour->position_level = null;
        $cour->education_level = 0;
        $cour->course_status = $request->input('course_status', 0);
        $cour->learn_format = $request->learn_format;
        $cour->shownumber = 0;
        $cour->prerequisites = 0;
        $cour->competencies = '';
        $cour->checkscore = 70;
        $cour->checktime = 0;
        $cour->survey_value = 0;
        $cour->suvey_complacence = 0;
        $cour->teacher = null;
        $cour->virtualclassroom = null;
        $cour->virtualclassroomlink = null;
        $cour->create_date = now();
        $cour->templete_certificate = $request->templete_certificate;
        $cour->hours = $request->hours;
        $cour->days = $request->days;
        $cour->signature_name = $request->signature_name;
        $cour->signature_position = $request->signature_position;
        $cour->result_learn_th = null;
        $cour->result_learn_en = null;
        $cour->course_approve = 0;
        $cour->cetificate_status = $request->input('cetificate_status', 0);;
        $cour->cetificate_request = 0;
        $cour->paymentstatus = $request->input('paymentstatus', 0);
        $cour->paymentmethod = '';
        $cour->price = $request->price;
        $cour->discount = $request->discount;
        $cour->discount_type = $request->discount_type;
        $cour->discount_data = '';
        $cour->bank = $request->bank;
        $cour->compcode = $request->compcode;
        $cour->taxid = $request->taxid;
        $cour->suffixcode = $request->suffixcode;

        set_time_limit(0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/uplade'))) {
            mkdir(public_path('/uplade'), 0755, true);
        }
        if ($request->has('paymentdetail')) {
            $paymentdetail = $request->paymentdetail;
            $decodedTextpaymentdetail = '';
            if (!empty($paymentdetail)) {
                $des_th = new DOMDocument();
                $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $paymentdetail = mb_convert_encoding($paymentdetail, 'HTML-ENTITIES', 'UTF-8');
                $paymentdetail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $paymentdetail);
                $des_th->loadHTML($paymentdetail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                $paymentdetail = $des_th->saveHTML();
                $decodedTextpaymentdetail = html_entity_decode($paymentdetail, ENT_QUOTES, 'UTF-8');
            }

            $cour->paymentdetail = $decodedTextpaymentdetail;
        }
        $cour->paymentdate = $request->paymentdate;
        $cour->payinslip = $request->input('payinslip', 0);
        $cour->creditcard = $request->input('creditcard', 0);
        $cour->promptpay = $request->input('promptpay', 0);
        $cour->discount_code = $request->discount_code;
        $cour->accountbook =  $request->accountbook;
        $cour->accountname =  $request->accountname;
        $cour->save();

        if ($request->hasFile('cover')) {
            $image_name = 'cover' . $cour->course_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/images/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/images/' . $image_name), file_get_contents($request->cover));
                $cour->cover = 'upload/Course/images/' . 'cover' . $cour->course_id . '.' . $request->cover->getClientOriginalExtension();
                $cour->save();
            }
        } else {
            $image_name = '';
            $cour->cover = $image_name;
            $cour->save();
        }

        if ($request->hasFile('signature')) {
            $image_signature = 'signature' . $cour->course_id . '.' . $request->signature->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/signature/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/signature/' . $image_signature), file_get_contents($request->signature));
                $cour->signature = 'upload/Course/signature/' .   'signature' . $cour->course_id . '.' . $request->signature->getClientOriginalExtension();
                $cour->save();
            }
        } else {
            $image_signature = '';
            $cour->signature = $image_signature;
            $cour->save();
        }

        if ($cour->templete_certificate == 1) {
            if (File::exists(public_path('uploads/cer03_0.png'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.png'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/cer03_0.png'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($cour->templete_certificate == 2) {
            if (File::exists(public_path('uploads/CER_11_0_0.jpg'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.jpg'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/CER_11_0_0.jpg'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($cour->templete_certificate == 3) {
            if (File::exists(public_path('uploads/CER_3_0_0.jpg'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.jpg'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/CER_3_0_0.jpg'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($request->hasFile('cert_custom')) {
            $image_cert_custom = 'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/cert_custom/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/cert_custom/' . $image_cert_custom), file_get_contents($request->cert_custom));
                $cour->cert_custom = 'upload/Course/cert_custom/' .   'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
                $cour->templete_certificate == 0;
                $cour->save();
            }
        } else {
            $image_cert_custom = '';
            $cour->cert_custom = $image_cert_custom;
            $cour->save();
        }

        if ($request->minScoreA) {
            $gradeA = new Grade();
            $gradeA->minscore = $request->minScoreA;
            $gradeA->course_id = $cour->course_id;
            $gradeA->grade = 'A';
            $gradeA->maxscore = null;
            $gradeA->description = null;
            $gradeA->save();
        } else {
        }
        if ($request->minScoreB) {
            $gradeB = new Grade();
            $gradeB->minscore = $request->minScoreB;
            $gradeB->course_id = $cour->course_id;
            $gradeB->grade = 'B';
            $gradeB->maxscore = null;
            $gradeB->description = null;
            $gradeB->save();
        } else {
        }

        if ($request->minScoreC) {
            $gradeC = new Grade();
            $gradeC->minscore = $request->minScoreC;
            $gradeC->course_id = $cour->course_id;
            $gradeC->grade = 'C';
            $gradeC->maxscore = null;
            $gradeC->description = null;
            $gradeC->save();
        } else {
        }
        if ($request->minScoreD) {
            $gradeD = new Grade();
            $gradeD->minscore = $request->minScoreD;
            $gradeD->course_id = $cour->course_id;
            $gradeD->grade = 'D';
            $gradeD->maxscore = null;
            $gradeD->description = null;
            $gradeD->save();
        } else {
        }


        // เช็คว่า COURSE_SUBJECT_ID มีอยู่หรือไม่
        foreach ($subjData as $subjectId) {
            // ถ้าไม่มีให้สร้างรายการใหม่
            DB::table('course_subjectlist')->insert([
                'course_id' => $cour->course_id,
                'subject_id' => $subjectId,
                'subject_status' => 1,
            ]);
        }




        return redirect()->route('courpag', [$department_id, 'group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function edit($department_id, $course_id)
    {

        $cour = Course::findOrFail($course_id);


        $pertype = PersonType::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();
        return view('page.manage.group.co.edit', compact('cour', 'subs', 'pertype', 'courses', 'depart'));
    }
    public function update(Request $request, $department_id, $course_id)
    {
        $cour = Course::findOrFail($course_id);

        $cour->course_th = $request->course_th;
        $cour->course_en = $request->course_en;
        $selectedsubject = $request->input('subject', []);
        $subjData = array_map('strval', $selectedsubject);
        $subj = json_encode($subjData);
        $cour->subject = $subj;
        $cour->recommended = $request->input('recommended', 0);
        $cour->evaluation = $request->evaluation;
        $cour->courseformat = $request->courseformat;
        $cour->learnday = $request->learnday;
        $cour->lesson_type = $request->lesson_type;
        $cour->age = $request->age;
        $cour->agework = $request->agework;
        $selectedperson_type = $request->input('person_type', []);
        $convertedData = array_map('strval', $selectedperson_type);
        $result = json_encode($convertedData);
        $cour->person_type = $result;
        $cour->course_status = $request->input('course_status', 0);
        $cour->learn_format = $request->learn_format;
        $cour->update_date = now();
        $cour->templete_certificate = $request->input('templete_certificate', 0);

        $cour->hours = $request->hours;
        $cour->days = $request->days;
        $cour->signature_name = $request->signature_name;
        $cour->signature_position = $request->signature_position;
        $cour->cetificate_status =  $request->input('cetificate_status', 0);;
        $cour->cetificate_request = 0;

        $cour->paymentstatus = $request->input('paymentstatus', 0);
        if ($cour->paymentstatus == 0) {
            $cour->payinslip = 0;
            $cour->creditcard = 0;
            $cour->promptpay = 0;
            $cour->paymentdetail = null;
            $cour->discount = null;
            $cour->discount_code = null;
            $cour->discount_type = null;
            $cour->bank = null;
            $cour->compcode = null;
            $cour->price = null;
            $cour->accountbook =  null;
            $cour->accountname =  null;
            $cour->taxid = null;
            $cour->suffixcode = null;
            $cour->paymentdate = $request->paymentdate;
        } else {
            $cour->payinslip = $request->input('payinslip', 0);
            $cour->creditcard = $request->input('creditcard', 0);
            $cour->promptpay = $request->input('promptpay', 0);
            set_time_limit(0);
            libxml_use_internal_errors(true);
            if (!file_exists(public_path('/uplade'))) {
                mkdir(public_path('/uplade'), 0755, true);
            }
            if ($request->has('paymentdetail')) {
                $paymentdetail = $request->paymentdetail;
                $decodedTextpaymentdetail = '';
                if (!empty($paymentdetail)) {
                    $des_th = new DOMDocument();
                    $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $paymentdetail = mb_convert_encoding($paymentdetail, 'HTML-ENTITIES', 'UTF-8');
                    $paymentdetail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $paymentdetail);
                    $des_th->loadHTML($paymentdetail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                    $paymentdetail = $des_th->saveHTML();
                    $decodedTextpaymentdetail = html_entity_decode($paymentdetail, ENT_QUOTES, 'UTF-8');
                }

                $cour->paymentdetail = $decodedTextpaymentdetail;
            }
            $cour->discount = $request->discount;

            $cour->discount_type = $request->discount_type;
            $cour->discount_code = $request->discount_code;
            $cour->bank = $request->bank;
            $cour->compcode = $request->compcode;
            $cour->price = $request->price;
            $cour->taxid = $request->taxid;
            $cour->suffixcode = $request->suffixcode;
            $cour->paymentdate = $request->paymentdate;
            $cour->accountbook =  $request->accountbook;
            $cour->accountname =  $request->accountname;
        }




 

        $cour->save();

        if ($request->hasFile('cover')) {
            $image_name = 'cover' . $cour->course_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/images/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/images/' . $image_name), file_get_contents($request->cover));
                $cour->cover = 'upload/Course/images/' . 'cover' . $cour->course_id . '.' . $request->cover->getClientOriginalExtension();
                $cour->save();
            }
        }
        if ($request->hasFile('signature')) {
            $image_signature = 'signature' . $cour->course_id . '.' . $request->signature->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/signature/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/signature/' . $image_signature), file_get_contents($request->signature));
                $cour->signature = 'upload/Course/signature/' .   'signature' . $cour->course_id . '.' . $request->signature->getClientOriginalExtension();
                $cour->save();
            }
        }

        if ($cour->templete_certificate == 1) {
            if (File::exists(public_path('uploads/cer02_0.png'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.png'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/cer02_0.png'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($cour->templete_certificate == 2) {
            if (File::exists(public_path('uploads/CER_11_0_0.jpg'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.jpg'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/CER_11_0_0.jpg'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($cour->templete_certificate == 3) {
            if (File::exists(public_path('uploads/CER_3_0_0.jpg'))) {
                // ตรวจสอบว่าไดเรกทอรีปลายทางสำหรับการบันทึกใหม่มีอยู่หรือไม่
                $uploadDirectory = public_path('upload/Course/cert_custom/');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true);
                }

                // กําหนดชื่อไฟล์ใหม่และคัดลอกไฟล์รูปภาพ
                $newImageName = 'cert_custom' . $cour->course_id . '.jpg'; // ตั้งชื่อใหม่ตามต้องการ
                File::copy(public_path('uploads/CER_3_0_0.jpg'), $uploadDirectory . $newImageName);

                // บันทึกชื่อไฟล์ใหม่ในฐานข้อมูล
                $cour->cert_custom = 'upload/Course/cert_custom/' . $newImageName;
                $cour->save();
            }
        } elseif ($request->hasFile('cert_custom')) {
            $image_cert_custom = 'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/cert_custom/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/cert_custom/' . $image_cert_custom), file_get_contents($request->cert_custom));
                $cour->cert_custom = 'upload/Course/cert_custom/' .   'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
                $cour->templete_certificate == 0;
                $cour->save();
            }
        }


        DB::table('course_subjectlist')
            ->where('course_id', $course_id)
            ->delete();

        foreach ($subjData as $subjectId) {
            DB::table('course_subjectlist')->insert([
                'course_id' => $course_id,
                'subject_id' => $subjectId,
                'subject_status' => 1,
            ]);
        }



        return redirect()->route('courpag', [$department_id, 'group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function structure($department_id, $course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);

        return view('page.manage.group.co.structure.index', compact('cour', 'courses', 'depart'));
    }

    public function update_structure(Request $request, $department_id, $course_id)
    {

        set_time_limit(0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/uplade'))) {
            mkdir(public_path('/uplade'), 0755, true);
        }

        $cour = Course::findOrFail($course_id);
        if ($request->has('description_th')) {
            $description_th = $request->description_th;
            $decodedTextdescription_th = '';
            if (!empty($description_th)) {
                $des_th = new DOMDocument();
                $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $description_th = mb_convert_encoding($description_th, 'HTML-ENTITIES', 'UTF-8');
                $description_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $description_th);
                $des_th->loadHTML($description_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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

            $cour->description_th = $decodedTextdescription_th;
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

            $cour->description_en = $decodedTextdescription_en;
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

            $cour->objectives_th = $decodedTextobjectives_th;
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

            $cour->objectives_en = $decodedTextobjectives_en;
        }
        if ($request->has('qualification_th')) {
            $qualification_th = $request->qualification_th;
            $decodedTextqualification_th = '';
            if (!empty($qualification_th)) {
                $qua_th = new DOMDocument();
                $qua_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $qualification_th = mb_convert_encoding($qualification_th, 'HTML-ENTITIES', 'UTF-8');
                $qualification_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $qualification_th);
                $qua_th->loadHTML($qualification_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                $qualification_th = $qua_th->saveHTML();
                $decodedTextqualification_th = html_entity_decode($qualification_th, ENT_QUOTES, 'UTF-8');
            }

            $cour->qualification_th = $decodedTextqualification_th;
        }
        if ($request->has('qualification_en')) {
            $qualification_en = $request->qualification_en;
            $decodedTextqualification_en = '';
            if (!empty($qualification_en)) {
                $qua_en = new DOMDocument();
                $qua_en->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $qualification_en = mb_convert_encoding($qualification_en, 'HTML-ENTITIES', 'UTF-8');
                $qualification_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $qualification_en);
                $qua_en->loadHTML($qualification_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                $qualification_en = $qua_en->saveHTML();
                $decodedTextqualification_en = html_entity_decode($qualification_en, ENT_QUOTES, 'UTF-8');
            }

            $cour->qualification_en = $decodedTextqualification_en;
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

            $cour->evaluation_th = $decodedTextevaluation_th;
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

            $cour->evaluation_en = $decodedTextevaluation_en;
        }


        $cour->save();

        return redirect()->route('courpag', [$department_id, 'group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }

    public function destroy($department_id, $course_id)
    {
        $cour = Course::findOrFail($course_id);

        $cour->delete();
        return redirect()->back()->with('message', 'Course ลบข้อมูลสำเร็จ');
    }


    public function changeStatus(Request $request)
    {
        $cour = Course::find($request->course_id);

        if ($cour) {
            $cour->course_status = $request->course_status;
            $cour->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล CourseGroup']);
        }
    }
}
