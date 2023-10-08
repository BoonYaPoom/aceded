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
    public function addusersCour(Request $request, $course_id, $m)
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

    public function saveSelectedUsers(Request $request, $course_id, $m)

    {
        $selectedUsers = $request->input('selectedUsers');
     

        // เตรียมคำสั่ง SQL
        $sql = "BEGIN
        Course_Learner(
            :class_id,
            :user_id,
            TO_DATE(:registerdate, 'YYYY-MM-DD HH24:MI:SS'), -- ตัวแปรที่มีค่าเป็นวันที่ต้องแปลงให้เป็นรูปแบบที่ถูกต้อง
            :learner_status,
            :course_id,
            :congratulation,
            TO_DATE(:congratulationdate, 'YYYY-MM-DD HH24:MI:SS'), -- ตัวแปรที่มีค่าเป็นวันที่ต้องแปลงให้เป็นรูปแบบที่ถูกต้อง
            TO_DATE(:survetdate, 'YYYY-MM-DD HH24:MI:SS'), -- ตัวแปรที่มีค่าเป็นวันที่ต้องแปลงให้เป็นรูปแบบที่ถูกต้อง
            :subject,
            TO_DATE(:realcongratulationdate, 'YYYY-MM-DD HH24:MI:SS'), -- ตัวแปรที่มีค่าเป็นวันที่ต้องแปลงให้เป็นรูปแบบที่ถูกต้อง
            :request_certificate,
            :approve_certificate,
            :printed_certificate,
            :patment_amount,
            :patment_price,
            :patment_status,
            TO_DATE(:patment_date, 'YYYY-MM-DD HH24:MI:SS'), -- ตัวแปรที่มีค่าเป็นวันที่ต้องแปลงให้เป็นรูปแบบที่ถูกต้อง
            :patment_file,
            :patment_comment,
            :patment_type,
            :book_year,
            :book_no,
            :number_no
        );
    END;";
 
        // เตรียม statement
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $DB_PORT = env('DB_PORT');
        $DB_SERVICE_NAME = env('DB_SERVICE_NAME');
        $DB_CONNECTION = env('DB_CONNECTION');
        $DB_HOST = env('DB_HOST'); // หากคุณต้องการระบุ Host ของ Oracle Database
        
        // เชื่อมต่อกับ Oracle Database ด้วย OCI8
        $oci8Connection = oci_connect($dbUsername, $dbPassword, $DB_HOST);
        $statement = oci_parse($oci8Connection, $sql);
        
        // ตั้งค่าค่าตัวแปรที่คุณต้องการผูก
        $class_id = 0;
        $user_id = $selectedUsers; // เปลี่ยนเป็นตัวแปรที่คุณต้องการผูก
        $registerdate = now();
        $learner_status = 1;
        $course_id = $course_id; // เปลี่ยนเป็นตัวแปรที่คุณต้องการผูก
        $congratulation = 0;
        $congratulationdate = null;
        $survetdate = null;
        $subject = [];
        $realcongratulationdate = null;
        $request_certificate = null;
        $approve_certificate = null;
        $printed_certificate = null;
        $patment_amount = null;
        $patment_price = null;
        $patment_status = null;
        $patment_date = null;
        $patment_file = null;
        $patment_comment = null;
        $patment_type = null;
        $book_year = null;
        $book_no = null;
        $number_no = null;
        
        // ผูกชื่อตัวแปรในคำสั่ง SQL
        oci_bind_by_name($statement, ':class_id', $class_id);
        oci_bind_by_name($statement, ':user_id', $user_id);
        oci_bind_by_name($statement, ':registerdate', $registerdate);
        oci_bind_by_name($statement, ':learner_status', $learner_status);
        oci_bind_by_name($statement, ':course_id', $course_id);
        oci_bind_by_name($statement, ':congratulation', $congratulation);
        oci_bind_by_name($statement, ':congratulationdate', $congratulationdate);
        oci_bind_by_name($statement, ':survetdate', $survetdate);
        oci_bind_by_name($statement, ':subject', $subject);
        oci_bind_by_name($statement, ':realcongratulationdate', $realcongratulationdate);
        oci_bind_by_name($statement, ':request_certificate', $request_certificate);
        oci_bind_by_name($statement, ':approve_certificate', $approve_certificate);
        oci_bind_by_name($statement, ':printed_certificate', $printed_certificate);
        oci_bind_by_name($statement, ':patment_amount', $patment_amount);
        oci_bind_by_name($statement, ':patment_price', $patment_price);
        oci_bind_by_name($statement, ':patment_status', $patment_status);
        oci_bind_by_name($statement, ':patment_date', $patment_date);
        oci_bind_by_name($statement, ':patment_file', $patment_file);
        oci_bind_by_name($statement, ':patment_comment', $patment_comment);
        oci_bind_by_name($statement, ':patment_type', $patment_type);
        oci_bind_by_name($statement, ':book_year', $book_year);
        oci_bind_by_name($statement, ':book_no', $book_no);
        oci_bind_by_name($statement, ':number_no', $number_no);
        
        oci_execute($statement);
        
        oci_free_statement($statement);
   
       
        return redirect()->back()->with('success', 'การบันทึก');
    }
    
    public function storeLearn(Request $request, $course_id, $m)
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
