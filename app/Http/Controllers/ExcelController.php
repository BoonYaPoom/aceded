<?php

namespace App\Http\Controllers;

use App\Exports\QuestionExport;
use App\Exports\ReportExport;
use App\Exports\SubjectExport;
use App\Exports\UserDepartExport;
use App\Exports\UserprovicExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\CouseImport;
use App\Imports\QuestionsImportClass;
use App\Imports\UsersImportClass;
use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\Question;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class ExcelController extends Controller
{
    public function exportClass()
    {
        // You can customize the response here, but for this example, you can just return an empty response.
        return response()->stream(function () {
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="exported_data.xlsx"',
        ]);
    }
    
    public function ReportExp()
    {
        return Excel::download(new ReportExport(), 'Administrator Management Report.xlsx');
    }
    public function exportUsersall()
    {
        return Excel::download(new UsersExport(), 'Administrator Management Users.xlsx');
    }
    public function exportUsers($department_id)
    {
        return Excel::download(new UserDepartExport($department_id), 'Administrator Management Users Department.xlsx');
    }
    public function exportUsersPro($department_id, $provicValue)
    {
        return Excel::download(new UserprovicExport($department_id, $provicValue), 'Administrator Management Users Province.xlsx');
    }
    public function exportSubject()
    {
        return Excel::download(new SubjectExport, 'Administrator Management System.xlsx');
    }
    public function questionExport()
    {
        return Excel::download(new QuestionExport, 'Question System.xlsx');
    }

    public function importall(Request $request)
    {


        // ใช้คำสั่ง Excel::import เพื่อนำเข้าข้อมูล CSV
        Excel::import(new CouseImport, $request->file('csv'));

        return back()->with('success', 'Imported successfully');
    }
    public function Questionimport(Request $request, $subject_id)
    {
        $questionsImport = new QuestionsImportClass($subject_id);

        if ($request->hasFile('fileexcel')) {
            try {
                $importedData = [];
                $importedData = Excel::toArray($questionsImport, $request->file('fileexcel'));
                if (count($importedData) > 0 && count($importedData[0]) > 0) {
                    // มีข้อมูลที่นำเข้า
                    foreach ($importedData[0] as $row) {
                        // เช็คว่าข้อมูลในแต่ละคอลัมน์ของ $row ถูกต้องหรือไม่
                        if ($row[0] == 'ข้อที่') {
                            continue;
                        }
                        // ข้อมูลถูกต้อง
                        if ($row[0] >= 1) {
                            // บันทึกข้อมูลเฉพาะเมื่อ $row[0] มากกว่า 2
                            $lastQuestionId = Question::max('question_id');
                            $questionType = 1;
                            $questionStatus = 1;
                            $score = 0;
                            $numChoice = 5;
                            $Choice6 = null;
                            $Choice7 = null;
                            $Choice8 = null;
                            $ordering = null;
                            $explainquestion = null;
                            $lessonId = 0;
                            $question_level = 0;

                            $newQuestion = new Question([
                                'question_id' => $lastQuestionId + 1,
                                'question' => $row[1],
                                'choice1' => $row[2],
                                'choice2' => $row[3],
                                'choice3' => $row[4],
                                'choice4' => $row[5],
                                'choice5' => $row[6],
                                'answer' => $row[7],
                                'explain' => $row[8],
                                'choice6' => $Choice6,
                                'choice7' => $Choice7,
                                'choice8' => $Choice8,
                                'question_type' => $questionType,
                                'question_status' => $questionStatus,
                                'score' => $score,
                                'numchoice' => $numChoice,
                                'ordering' => $ordering,
                                'explainquestion' => $explainquestion,
                                'lesson_id' => $lessonId,
                                'subject_id' => $subject_id,
                                'question_level' => $question_level,
                            ]);

                            $newQuestion->save();
                        }
                    }


                    return response()->json(['message' => 'Import successfully'], 200);
                } else {
                    return response()->json(['error' => 'No data found in the imported file'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error importing data: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }
    public function UsersImport(Request $request)
    {
        $UsersImports = new UsersImportClass();

        if ($request->hasFile('fileexcel')) {
            try {
                $importedDataUser = Excel::toArray($UsersImports, $request->file('fileexcel'));
                if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
                    // มีข้อมูลที่นำเข้า
                    foreach ($importedDataUser[0] as $row) {
                        // เช็คว่าข้อมูลในแต่ละคอลัมน์ของ $row ถูกต้องหรือไม่
                        if ($row[0] == 'ลำดับ') {
                            continue;
                        }
                        // ข้อมูลถูกต้อง
                        if ($row[0] >= 1) {
                            $user_idplus = Users::max('user_id') ?? 0;
                            $user_role = 5;
                            $prefix = null;
                            $gender = null;
                            $per_id = null;
                            $department_id = 0;
                            $permission = null;
                            $ldap = 0;
                            $userstatus = 1;
                            $createdate = now();
                            $createby = 2;
                            $avatar = '';
                            $user_position = '';
                            $workplace = '';
                            $telephone = '';

                            $socialnetwork = '';
                            $experience = null;
                            $recommened = null;
                            $templete = null;
                            $nickname = '';
                            $introduce = '';
                            $bgcustom = '';
                            $pay = '';
                            $education = '';
                            $teach = '';
                            $modern = '';
                            $other = '';
                            $profiles = null;
                            $editflag = null;
                            $pos_level = 0;
                            $pos_name = '';
                            $sector_id = 0;
                            $office_id = 0;

                            $user_type = null;
                            $province_id = 0;
                            $district_id = 0;
                            $subdistrict_id = 0;
                            $recoverpassword = null;
                            $employeecode = null;
                            $organization = null;

                            $newUsers = new Users([
                                'user_id' =>  $user_idplus + 1,
                                'username' => $row[1],
                                'password' => Hash::make($row[2]),
                                'firstname' => $row[3],
                                'lastname' => $row[4],
                                'mobile' => $row[5],
                                'email' => $row[6],
                                'citizen_id' =>   $row[7],
                                'prefix' =>  $prefix,
                                'gender' => $gender,
                                'user_role' => $user_role,
                                'per_id' => $per_id,
                                'department_id' => $department_id,
                                'permission' => $permission,
                                'ldap' => $ldap,
                                'userstatus' => $userstatus,
                                'createdate' => $createdate,
                                'createby' => $createby,
                                'avatar' => $avatar,
                                'user_position' =>  $user_position,
                                'workplace' =>  $workplace,
                                'telephone' =>  $telephone,

                                'socialnetwork' =>  $socialnetwork,
                                'experience' =>  $experience,
                                'recommened' => $recommened,
                                'templete' => $templete,
                                'nickname' =>  $nickname,
                                'introduce' => $introduce,
                                'bgcustom' =>  $bgcustom,
                                'pay' =>  $pay,
                                'education' => $education,
                                'teach' => $teach,
                                'modern' => $modern,
                                'other' => $other,
                                'profiles' =>  $profiles,
                                'editflag' => $editflag,
                                'pos_level' => $pos_level,
                                'pos_name' => $pos_name,
                                'sector_id' =>  $sector_id,
                                'office_id' => $office_id,
                                'user_type' => $user_type,
                                'province_id' => $province_id,
                                'district_id' => $district_id,
                                'subdistrict_id' =>  $subdistrict_id,
                                'recoverpassword' =>  $recoverpassword,
                                'employeecode' =>  $employeecode,
                                'organization' =>  $organization,
                            ]);


                            $newUsers->save();
                        }
                    }


                    return response()->json(['message' => 'Import successfully'], 200);
                } else {
                    return response()->json(['error' => 'No data found in the imported file'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error importing data: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }
}
