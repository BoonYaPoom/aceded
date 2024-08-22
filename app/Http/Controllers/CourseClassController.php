<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseGroup;
use App\Models\CourseLearner;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CourseClassController extends Controller
{
    public function classpage($department_id,$course_id)
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
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.index', compact('cour', 'class', 'month', 'learners', 'depart'));
    }



    public function create($department_id,$course_id)
    {

        $cour = Course::findOrFail($course_id);
        $class = $cour->classCouse()->where('course_id', $course_id)->get();
        $learn = CourseLearner::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.create', compact('cour', 'class', 'learn', 'depart'));
    }
    public function edit($department_id,$class_id)
    {

        $class = CourseClass::FindOrFail($class_id);
        $course_id =   $class->course_id;
        $cour = Course::findOrFail($course_id);
        $learn = CourseLearner::all();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.edit', compact('class', 'learn', 'cour', 'depart'));
    }

    public function store(Request $request, $department_id,$course_id)
    {
        try {
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

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
        }
        return redirect()->route('class_page', [$department_id,'course_id' => $course_id])->with('message', 'CourseClass บันทึกข้อมูลสำเร็จ');
    }

    public function update(Request $request,$department_id, $class_id)
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


        return redirect()->route('class_page', [$department_id,'course_id' => $class->course_id])->with('message', 'CourseClass บันทึกข้อมูลสำเร็จ');
    }


    public function teacherinfo()
    {

        return view('page.manage.group.co.classroom.item.congratuation.teacherinfo');
    }

    public function Teacherinfoupdate(Request $request,$department_id, $user_id)
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
            $usermanages->avatar = 'upload/Profile/' . 'avatar' .  $user_id . '.' . $request->avatar->getClientOriginalExtension();
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

    public function registeradd($department_id,$course_id)
    {
        $cour = Course::findOrFail($course_id);
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classroom.item.registeradd', compact('cour', 'depart'));
    }


    public function report($department_id,$course_id, $m)
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
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.item.report.report', compact('cour', 'learners', 'm', 'courses', 'depart'));
    }
    public function gpapage($department_id,$course_id, $m)
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
        $depart = Department::find($department_id);



        return view('page.manage.group.co.classrooms.item.report.gpapage', compact('cour', 'learners', 'm', 'courses', 'depart'));
    }
    public function congratuation($department_id,$course_id, $m)
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
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.item.congratuation.congratuation', compact('cour', 'courses', 'learners', 'm', 'courses', 'depart'));
    }

    public function payment($department_id,$class_id)
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
        $depart = Department::find($department_id);
        return view('page.manage.group.co.classrooms.item.payment.payment', compact('class', 'learn', 'cour', 'depart'));
    }
    public function payment2($department_id,$class_id)
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
        $depart = Department::find($department_id);

        return view('page.manage.group.co.classrooms.item.payment.payment', compact('class', 'learn', 'cour', 'depart'));
    }

    public function register($department_id,$course_id, $m)
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
        $depart = Department::find($department_id);
        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $usersser = [];
        return view('page.manage.group.co.classrooms.item.register.register', compact('courses', 'cour', 'learners', 'm', 'depart', 'usersser'));
    }


    public function searchUsers(Request $request, $department_id,$course_id, $m)
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
        $depart = Department::find($department_id);
        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $searchQuery = $request->input('search_query');

        $usersser = $depart->UserDe()
            ->whereNotExists(function ($query) use ($searchQuery) {
                $query->select(DB::raw(1))
                    ->from('course_learner')
                    ->whereRaw('course_learner.user_id = users.user_id')
                    ->where('user_id', 'LIKE', "%$searchQuery%");
            })
            ->where('user_id', 'LIKE', "%$searchQuery%")
            ->get();


        return view('page.manage.group.co.classrooms.item.register.register', compact('searchQuery', 'courses', 'cour', 'learners', 'm', 'depart', 'usersser'))
            ->with('refreshPage', true);
    }

    public function storeLearn(Request $request,$department_id, $course_id, $m)
    {


        $selectedUserIds = $request->user_data;

        $courseLearner = new CourseLearner();

        $courseLearner->class_id = 0;
        $courseLearner->user_id = $selectedUserIds;
        $courseLearner->registerdate = now();
        $courseLearner->learner_status = 1;
        $courseLearner->course_id = $course_id;
        $courseLearner->congratulation = 0;
        $courseLearner->congratulationdate = null;
        $courseLearner->survetdate = null;
        $courseLearner->subject = [];
        $courseLearner->realcongratulationdate  =  null;
        $courseLearner->request_certificate  =  null;
        $courseLearner->approve_certificate  =  null;
        $courseLearner->printed_certificate  =  null;
        $courseLearner->patment_amount  =  null;
        $courseLearner->patment_price  =  null;
        $courseLearner->patment_status  =  null;
        $courseLearner->patment_date  =  null;
        $courseLearner->patment_file  =  null;
        $courseLearner->patment_comment  =  null;
        $courseLearner->patment_type  =  null;
        $courseLearner->book_year  =  null;
        $courseLearner->book_no  =  null;
        $courseLearner->number_no  =  null;

        $courseLearner->save();

        return redirect()->back()->with('error', 'โปรดเลือกข้อมูลที่ต้องการบันทึก');
    }
}
