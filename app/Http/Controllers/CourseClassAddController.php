<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGroup;
use App\Models\CourseLearner;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class CourseClassAddController extends Controller
{
    public function addusersCour(Request $request,$department_id, $course_id, $m)
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

        $usersInDepartment = $depart->UserDe;
        // ดึงรายชื่อผู้ใช้ที่มี user_id ไม่อยู่ใน $learners
        $filteredUsers = $usersInDepartment->whereNotIn('user_id', $learners->pluck('user_id'));



        return view('page.manage.group.co.classrooms.item.register.addregis', compact('filteredUsers', 'courses', 'cour', 'learners', 'm', 'depart'));
    }

    public function saveSelectedUsers(Request $request, $department_id,$course_id, $m)

    {

        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('course_learner')->insert([
                'class_id' => 0,
                'user_id' => $userId,
                'registerdate' => now(),
                'learner_status' => 1,
                'course_id' => $course_id,
                'congratulation' => 0,
                'congratulationdate' => null,
                'surveydate' => null,
                'subject' => json_encode([]), // แปลงเป็น JSON ถ้าต้องการ
                'realcongratulationdate' => null,
                'request_certificate' => null,
                'approve_certificate' => null,
                'printed_certificate' => null,
                'payment_amount' => null,
                'payment_price' => null,
                'payment_status' => null,
                'payment_date' => null,
                'payment_file' => null,
                'payment_comment' => null,
                'payment_type' => null,
                'book_year' => null,
                'book_no' => null,
                'number_no' => null,
            ]);
        }

        return redirect()->route('register_page', [$department_id,'m' => $m, 'course_id' => $course_id])->with('message', 'การบันทึก');
    }
    public function destroy($learner_id)
    {
        $learn = CourseLearner::findOrFail($learner_id);

        $learn->delete();
        return redirect()->back()->with('message', 'learn ลบข้อมูลสำเร็จ');
    }
    public function changeStatusLearner(Request $request)
    {
        $learn = CourseLearner::find($request->learner_id);

        if ($learn) {
            $learn->learner_status = $request->learner_status;
            $learn->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล CourseGroup']);
        }
    }
    
}
