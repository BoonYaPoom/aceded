<?php

namespace App\Http\Controllers;

use App\Models\Course;

use App\Models\CourseGroup;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\PersonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function courpag($group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);
        $cour = $courses->group()->where('group_id', $group_id)->get();
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.index', compact('courses', 'cour','depart'));
    }

    public function create($group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);

        $pertype = PersonType::all();
        
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();
        return view('page.manage.group.co.create', compact('courses', 'subs', 'pertype','depart'));
    }

    public function store(Request $request, $group_id)
    {
      

        $validator = Validator::make($request->all(), [
            'course_code' => 'required',
            'course_th' => 'required'
        ]);
      
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try{
        $code = Course::generateCourseCode($group_id);
        $group = CourseGroup::find($group_id);
        $department_id = $group->department_id;
        $department = Department::find($department_id);   
        $departmentId = $department->name_short_en; 
        $codes =$departmentId . str_pad($code, 3, '0', STR_PAD_LEFT)  ;
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
        $cour->cetificate_status = $request->input('cetificate_status', 0);
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
        $cour->promptpay = '';
        $cour->accountbook = '';
        $cour->paymentdetail = $request->paymentdetail;
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

        if ($request->hasFile('cert_custom')) {
            $image_cert_custom = 'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/cert_custom/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/cert_custom/' . $image_cert_custom), file_get_contents($request->cert_custom));
                $cour->cert_custom = 'upload/Course/cert_custom/' .  'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
                $cour->save();
            }
        } else {
            $image_cert_custom = '';
            $cour->cert_custom = $image_cert_custom;
            $cour->save();
        }
        DB::commit();
    } catch (\Exception $e) {

        DB::rollBack();

        return response()->view('errors.500', [], 500);
    }
        return redirect()->route('courpag', ['group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function edit($course_id)
    {
        $cour = Course::findOrFail($course_id);

        $pertype = PersonType::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id);
        $subs = $depart->SubjectDe()->where('department_id', $department_id)->get();
        return view('page.manage.group.co.edit', compact('cour', 'subs', 'pertype', 'courses','depart'));
    }
    public function update(Request $request, $course_id)
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
        $cour->templete_certificate = $request->templete_certificate;
      
        $cour->hours = $request->hours;
        $cour->days = $request->days;   
        $cour->signature_name = $request->signature_name;
        $cour->signature_position = $request->signature_position;
        $cour->cetificate_status = $request->input('cetificate_status', 0);
        $cour->cetificate_request = 0;
        $cour->paymentstatus = $request->input('paymentstatus', 0);
        $cour->price = $request->price;
        $cour->discount = $request->discount;
        $cour->discount_type = $request->discount_type;
        $cour->bank = $request->bank;
        $cour->compcode = $request->compcode;
        $cour->taxid = $request->taxid;
        $cour->suffixcode = $request->suffixcode;
        $cour->paymentdetail = $request->paymentdetail;
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
        if ($request->hasFile('cert_custom')) {
            $image_cert_custom = 'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Course/cert_custom/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Course/cert_custom/' . $image_cert_custom), file_get_contents($request->cert_custom));
                $cour->cert_custom = 'upload/Course/cert_custom/' .  'cert_custom' . $cour->course_id . '.' . $request->cert_custom->getClientOriginalExtension();
                $cour->save();
            }
        } 
        return redirect()->route('courpag', ['group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function structure($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.structure.index', compact('cour', 'courses','depart'));
    }

    public function update_structure(Request $request, $course_id)
    {
        set_time_limit(0);
        $cour = Course::findOrFail($course_id);
        $cour->description_th = $request->description_th;
        $cour->description_en = $request->description_en;
        $cour->objectives_th = $request->objectives_th;
        $cour->objectives_en = $request->objectives_en;
        $cour->qualification_th = $request->qualification_th;
        $cour->qualification_en = $request->qualification_en;
        $cour->evaluation_th = $request->evaluation_th;
        $cour->evaluation_en = $request->evaluation_en;

        $cour->save();

        return redirect()->route('courpag', ['group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }

    public function destroy($course_id)
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
