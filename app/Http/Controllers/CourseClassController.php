<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseGroup;
use App\Models\CourseLearner;
use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CourseClassController extends Controller
{
    public function classpage($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $class = $cour->classCouse()->where('course_id', $course_id)->get();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.index', compact('cour', 'class', 'month', 'learners','depart'));
    }



    public function create($course_id)
    {

        $cour = Course::findOrFail($course_id);
        $class = $cour->classCouse()->where('course_id', $course_id)->get();
        $learn = CourseLearner::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.create', compact('cour', 'class', 'learn','depart'));
    }
    public function edit($class_id)
    {

        $class = CourseClass::FindOrFail($class_id);
        $course_id =   $class->course_id;
        $cour = Course::findOrFail($course_id);
        $learn = CourseLearner::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.edit', compact('class', 'learn', 'cour','depart'));
    }

    public function store(Request $request, $course_id)
    {

        $class = new CourseClass;
        $class->class_name = $request->class_name;
        $class->course_id = (int)$course_id;
   
        $class->class_status  = $request->input('class_status', 0);
        $class->startdate = $request->startdate;
        $class->enddate = $request->enddate;
        $class->announcementdate = $request->announcementdate;
        $class->amount = $request->amount;
        $class->ageofcert = $request->ageofcert;
        $class->registration = null;
        $class->registration_file = null;
        $class->part3 = null;
        $class->location = null;
        $class->orderby = null;
        $class->selectby = null;
        $class->startcourse = null;
        $class->endcourse = null;
        $class->save();


        return redirect()->route('class_page', ['course_id' => $course_id])->with('message', 'CourseClass บันทึกข้อมูลสำเร็จ');
    }

    public function update(Request $request, $class_id)
    {
        $class = CourseClass::FindOrFail($class_id);
        $class->class_name = $request->class_name;

        $class->startdate = $request->startdate;
        $class->class_status  = $request->input('class_status', 0);
        $class->enddate = $request->enddate;
        $class->announcementdate = $request->announcementdate;
        $class->amount = $request->amount;
        $class->ageofcert = $request->ageofcert;

        $class->save();


        return redirect()->route('class_page', ['course_id' => $class->course_id])->with('message', 'CourseClass บันทึกข้อมูลสำเร็จ');
    }


    public function teacherinfo()
    {

        return view('page.manage.group.co.classroom.item.congratuation.teacherinfo');
    }

    public function Teacherinfoupdate(Request $request, $user_id)
    {

        $usermanages = Users::findOrFail($user_id);
        if ($request->hasFile('avatar')) {
            $image_name = 'avatar' .  $user_id . '.' . $request->avatar->getClientOriginalExtension();
            $image = Image::make($request->avatar)->resize(400, 400);
            $uploadDirectory = public_path('upload/Profile/' . $image_name);
            
            if (!file_exists(dirname($uploadDirectory))) {
                mkdir(dirname($uploadDirectory), 0755, true);
            }
        
            $image->save($uploadDirectory);
            $usermanages->avatar = 'upload/Profile/' . 'avatar' .  $user_id .'.' . $request->avatar->getClientOriginalExtension();
        }
        

        // ... อัปเดตฟิลด์อื่น ๆ ตามต้องการ
        $usermanages->user_position = $request->user_position;
        $usermanages->department = $request->department;
        $usermanages->workplace  = $request->workplace;


        $usermanages->telephone = $request->telephone;


        $usermanages->mobile = $request->mobile;
        $usermanages->pay = $request->pay;
        $usermanages->education = $request->education;
        $usermanages->experience = $request->experience;
        $usermanages->skill = $request->skill;


        $selectedsocialnetwork = $request->input('socialnetwork', []);
        $convertedData = array_map('strval', $selectedsocialnetwork);
        $result = json_encode($convertedData);
        $usermanages->socialnetwork = $result;

        $usermanages->modifieddate = now();



        $usermanages->user_type = $request->input('user_type', 0);
        $usermanages->gender = $request->input('gender', 0);



        // บันทึกการเปลี่ยนแปลง
        $usermanages->save();

        // ส่งข้อความสำเร็จไปยังหน้าแก้ไขโปรไฟล์
        return redirect()->route('UserManage')->with('message', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    public function registeradd($course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classroom.item.registeradd', compact('cour','depart'));
    }
    public function register($course_id,$m)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $cour = Course::findOrFail($course_id);
        $class = $cour->classCouse()->where('course_id', $course_id)->get();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();

        return view('page.manage.group.co.classrooms.item.register.register', compact('courses','cour', 'learners', 'm','depart'));
    }


    public function report($course_id,$m)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $cour = Course::findOrFail($course_id);

        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.item.report.report', compact('cour', 'learners', 'm','courses','depart'));
    }
    public function congratuation($course_id,$m)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::where('group_id', $group_id)->get();
        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.item.congratuation.congratuation', compact('cour','courses', 'learners', 'm','courses','depart'));
    }

    public function payment($class_id)
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $class = CourseClass::FindOrFail($class_id);
        $learn = $class->classLearn()->where('class_id', $class_id)->get();
        $course_id =   $class->course_id;
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.item.payment.payment', compact('class', 'learn', 'cour','depart'));
    }
    public function payment2($class_id)
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $class = CourseClass::FindOrFail($class_id);
        $learn = $class->classLearn()->where('class_id', $class_id)->get();
        $course_id =   $class->course_id;
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 
        return view('page.manage.group.co.classrooms.item.payment.payment', compact('class', 'learn', 'cour','depart'));
    }

    public function register2($m)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];

        $learn = CourseLearner::all();


        return view('page.manage.group.co.classrooms.item.register.register', compact('class', 'learn', 'cour'));
    }
}
