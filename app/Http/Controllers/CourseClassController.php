<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseLearner;
use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CourseClassController extends Controller
{
    public function classpage($course_id)
    {
        $learner = CourseLearner::all();
        $cour = Course::findOrFail($course_id);
        $class = $cour->classCouse()->where('course_id', $course_id)->get();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];

        return view('page.manage.group.co.classroom.index', compact('cour', 'class', 'month', 'learner'));
    }



    public function create($course_id)
    {

        $cour = Course::findOrFail($course_id);
        $class = $cour->classCouse()->where('course_id', $course_id)->get();

        return view('page.manage.group.co.classroom.create', compact('cour', 'class'));
    }

    public function store(Request $request, $course_id)
    {

        $class = new CourseClass;
        $class->class_name = $request->class_name;
        $class->course_id = (int)$course_id;
        $class->startdate = $request->startdate;
        $class->class_status  = $request->input('class_status', 0);
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


    public function registeradd($course_id)
    {
        $cour = Course::findOrFail($course_id);
        return view('page.manage.group.co.classroom.item.registeradd', compact('cour'));
    }
    public function register($month)
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];

        return view('page.manage.group.co.classroom.item.register.register', compact('month'));
    }
    public function report($course_id)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];

        return view('page.manage.group.co.classroom.item.report.report', compact('month'));
    }
    public function congratuation($course_id)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];

        return view('page.manage.group.co.classroom.item.congratuation.congratuation', compact('month'));
    }
    public function teacherinfo()
    {

        return view('page.manage.group.co.classroom.item.congratuation.teacherinfo');
    }

    public function Teacherinfoupdate(Request $request, $uid)
    {

        $usermanages = Users::findOrFail($uid);

        if ($request->hasFile('avatar')) {
            // ลบรูปภาพเก่า (ถ้ามี)
            if ($usermanages->avatar) {
                $oldImagePath = public_path('profile') . '/' . $usermanages->avatar;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image_name = time() . '.' . $request->avatar->getClientOriginalExtension();
            Storage::disk('external')->put('profile/' . $image_name, file_get_contents($request->avatar));
            $image = Image::make($request->avatar)->resize(400, 400);
            Storage::disk('external')->put('profile/' . $image_name, $image->stream());
            $usermanages->avatar = $image_name;
        }

        // ... อัปเดตฟิลด์อื่น ๆ ตามต้องการ
        $usermanages->position = $request->position;
        $usermanages->department = $request->department;
        $usermanages->workplace  = $request->workplace ;


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
}
