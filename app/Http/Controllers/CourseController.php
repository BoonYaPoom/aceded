<?php

namespace App\Http\Controllers;

use App\Models\Course;

use App\Models\CourseGroup;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\PersonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{

    public function courpag($group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);
        $cour = $courses->group()->where('group_id', $group_id)->get();
        return view('page.manage.group.co.index', compact('courses', 'cour'));
    }

    public function create($group_id)
    {
        $courses = CourseGroup::findOrFail($group_id);
        $subs = CourseSubject::all();
        $pertype = PersonType::all();
        return view('page.manage.group.co.create', compact('courses', 'subs', 'pertype'));
    }

    public function store(Request $request, $group_id)
    {
        $request->validate([
            'course_code' => 'required',
            'course_th' => 'required'
        ]);


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

        if ($request->hasFile('cover')) {
            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Course/images/' . $image_name, file_get_contents($request->cover));
        } else {
            $image_name = '';
        }

        $cour->cover = $image_name;

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

        if ($request->hasFile('signature')) {
            $image_signature = time() . '.' . $request->signature->getClientOriginalExtension();
            Storage::disk('external')->put('Course/signature/' . $image_signature, file_get_contents($request->signature));
        } else {
            $image_signature = '';
        }

        $cour->signature = $image_signature;


        $cour->hours = $request->hours;
        $cour->days = $request->days;

        if ($request->hasFile('cert_custom')) {

            $image_cert = time() . '.' . $request->cert_custom->getClientOriginalExtension();
            Storage::disk('external')->put('Course/cert_custom/' . $image_cert, file_get_contents($request->cert_custom));
        } else {
            $image_cert = '';
        }

        $cour->cert_custom =  'images/' . $image_cert;
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

        return redirect()->route('courpag', ['group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function edit($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $subs = CourseSubject::all();
        $pertype = PersonType::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::where('group_id', $group_id)->get();
        return view('page.manage.group.co.edit', compact('cour', 'subs', 'pertype', 'courses'));
    }
    public function update(Request $request, $course_id)
    {
        $cour = Course::findOrFail($course_id);

        $cour->course_th = $request->course_th;
        $cour->course_en = $request->course_en;

        if ($request->hasFile('cover')) {
            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Course/images/' . $image_name, file_get_contents($request->cover));
            $cour->cover = 'images/' . $image_name;
        }

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

        if ($request->hasFile('signature')) {
            $image_signature = time() . '.' . $request->signature->getClientOriginalExtension();
            Storage::disk('external')->put('Course/signature/' . $image_signature, file_get_contents($request->signature));
            $cour->signature = 'images/' . $image_signature;
        }




        $cour->hours = $request->hours;
        $cour->days = $request->days;

        if ($request->hasFile('cert_custom')) {

            $image_cert = time() . '.' . $request->cert_custom->getClientOriginalExtension();
            Storage::disk('external')->put('Course/cert_custom/' . $image_cert, file_get_contents($request->cert_custom));
            $cour->cert_custom =  'images/' . $image_cert;
        }


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

        return redirect()->route('courpag', ['group_id' => $cour->group_id])->with('message', 'CourseGroup บันทึกข้อมูลสำเร็จ');
    }
    public function structure($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::where('group_id', $group_id)->get();
        return view('page.manage.group.co.structure.index', compact('cour', 'courses'));
    }

    public function update_structure(Request $request, $course_id)
    {
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


        if (Storage::disk('external')->exists('Course/images/' .  $cour->cover)) {
            Storage::disk('external')->delete('Course/images/' .  $cour->cover);
        }
        if (Storage::disk('external')->exists('Course/cert_custom/' . $cour->cert_custom)) {
            Storage::disk('external')->delete('Course/cert_custom/' . $cour->cert_custom);
        }
        if (Storage::disk('external')->exists('Course/signature/' .  $cour->signature)) {
            Storage::disk('external')->delete('Course/signature/' .  $cour->signature);
        }


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
