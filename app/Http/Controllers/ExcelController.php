<?php

namespace App\Http\Controllers;

use App\Exports\LearnerExport;
use App\Exports\QuestionExport;
use App\Exports\report\AllT0000;
use App\Exports\report\t0101All;
use App\Exports\report\t0103All;
use App\Exports\report\t0116All;
use App\Exports\report\t0117All;
use App\Exports\report\t0118All;
use App\Exports\report\t0119All;
use App\Exports\report\t0120All;
use App\Exports\ReportExport;
use App\Exports\SubjectExport;
use App\Exports\t0101;
use App\Exports\t0103;
use App\Exports\t0116;
use App\Exports\t0117;
use App\Exports\t0118;
use App\Exports\t0119;
use App\Exports\t0120;
use App\Exports\UserDepartExport;
use App\Exports\UserProvicAll;
use App\Exports\UserprovicExport;
use App\Models\User;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\UsersSchoolImportss;
use App\Exports\UsersZoneImportss;
use App\Imports\CouseImport;
use App\Imports\QuestionsImport2Class;
use App\Imports\QuestionsImportClass;
use App\Imports\SchoolDpimportClass;
use App\Imports\UserAlldepartClass;
use App\Imports\UserDepartimport;
use App\Imports\UsersImportClass;
use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\Extender2;
use App\Models\Log;
use App\Models\Question;
use App\Models\UserDepartment;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Validator;

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
    public function exportUserProvicAll($provicValue)
    {
        return Excel::download(new UserProvicAll($provicValue), 'Administrator Management Users Province.xlsx');
    }
    public function exportT0101($department_id, $provin_name, $year)
    {

        return Excel::download(new t0101($department_id, $provin_name, $year), 'T0101 ของจังหวัด' . $provin_name .  ' ปี' . $year . ' .xlsx');
    }
    public function exportT0116($department_id, $provin_name, $year)
    {

        return Excel::download(new t0116($department_id, $provin_name, $year), 'T0116 ของจังหวัด' . $provin_name .  ' ปี' . $year . ' .xlsx');
    }
    public function exportT0103($year)
    {

        return Excel::download(new t0103($year), 't0103 ปี' . $year . ' .xlsx');
    }

    public function exportT0117($year)
    {

        return Excel::download(new t0117($year), 't0117 ปี' . $year . ' .xlsx');
    }

    public function exportT0118($provin_name, $year)
    {

        return Excel::download(new t0118($provin_name, $year), 'T0118 ของจังหวัด' . $provin_name .  ' ปี' . $year . ' .xlsx');
    }
    public function exportT0119($provin_name, $year)
    {

        return Excel::download(new t0119($provin_name, $year), 't0119 ของจังหวัด' . $provin_name .  ' ปี' . $year . ' .xlsx');
    }
    public function exportT0120($department_id, $provin_name)
    {
        return Excel::download(new t0120($department_id, $provin_name), 't0120 ของจังหวัด' . $provin_name . ' .xlsx');
    }
    public function exportT0101ALL($year)
    {
        return Excel::download(new t0101All($year), 'T0101 ' . $year . '.xlsx');
    }
    public function exportT0116ALL($year)
    {

        return Excel::download(new t0116All($year), 'T0116 ' . $year . '.xlsx');
    }
    public function exportT0103ALL($year)
    {

        return Excel::download(new t0103All($year), 't0103 ' . $year . '.xlsx');
    }

    public function exportT0117ALL($year)
    {

        return Excel::download(new t0117All($year), 't0117 ' . $year . '.xlsx');
    }

    public function exportT0118ALL($year)
    {

        return Excel::download(new t0118All($year), 'T0118 ' . $year . '.xlsx');
    }
    public function exportT0119ALL($year)
    {

        return Excel::download(new t0119All($year), 't0119 ' . $year . '.xlsx');
    }
    public function exportT0120ALL()
    {
        return Excel::download(new t0120All(), 't0120.xlsx');
    }
    public function exportAllT0000()
    {
        return Excel::download(new AllT0000(), 'AllT0000.xlsx');
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

    public function exportUsersSchool($department_id)
    {
        return Excel::download(new UsersSchoolImportss($department_id), 'Administrator Management Users School.xlsx');
    }
    public function exportUsersZone($department_id)
    {
        return Excel::download(new UsersZoneImportss($department_id), 'Administrator Management Users Zone.xlsx');
    }
    public function exportSubject()
    {
        return Excel::download(new SubjectExport, 'Administrator Management System.xlsx');
    }
    public function questionExport($subject_id)
    {
        return Excel::download(new QuestionExport($subject_id), 'Question System.xlsx');
    }

    public function importall(Request $request)
    {
        // ใช้คำสั่ง Excel::import เพื่อนำเข้าข้อมูล CSV
        Excel::import(new CouseImport, $request->file('csv'));

        return back()->with('message', 'Imported successfully');
    }
    public function Questionimport(Request $request, $department_id, $subject_id)
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
                            $score = 1;
                            $numChoice = count(array_filter([
                                $row[2] !== '' ? $row[2] : null,
                                $row[3] !== '' ? $row[3] : null,
                                $row[4] !== '' ? $row[4] : null,
                                $row[5] !== '' ? $row[5] : null,
                                $row[6] !== '' ? $row[6] : null,
                            ]));

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
                                'choice1' => isset($row[2]) ? $row[2] : null,
                                'choice2' => isset($row[3]) ? $row[3] : null,
                                'choice3' => isset($row[4]) ? $row[4] : null,
                                'choice4' => isset($row[5]) ? $row[5] : null,
                                'choice5' => isset($row[6]) ? $row[6] : null,
                                'answer' => '["' . strval($row[7]) . '"]',
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
    public function Questionimport2(Request $request, $department_id, $subject_id)
    {
        $questionsImport = new QuestionsImport2Class($subject_id);

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
                            $score = 1;
                            $numChoice = count(array_filter([
                                $row[2] !== '' ? $row[2] : null,
                                $row[3] !== '' ? $row[3] : null,
                                $row[4] !== '' ? $row[4] : null,
                                $row[5] !== '' ? $row[5] : null,
                                $row[6] !== '' ? $row[6] : null,
                            ]));

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
                                'choice1' => isset($row[2]) ? $row[2] : null,
                                'choice2' => isset($row[3]) ? $row[3] : null,
                                'choice3' => isset($row[4]) ? $row[4] : null,
                                'choice4' => isset($row[5]) ? $row[5] : null,
                                'choice5' => isset($row[6]) ? $row[6] : null,
                                'answer' => '["' . strval($row[7]) . '"]',
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

            $importedDataUser = Excel::toArray($UsersImports, $request->file('fileexcel'));
            if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
                // มีข้อมูลที่นำเข้า
                $duplicateFields = [];

                foreach ($importedDataUser[0] as $rowsss) {
                    if ($rowsss[0] == 'ลำดับ') {
                        continue;
                    }
                    if ($rowsss[0] >= 1) {
                        if (empty(trim($rowsss[7]))) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนไม่สามารถเป็นค่าว่างได้';
                        }
                        $trimmedName = trim($rowsss[1]);
                        if (in_array($trimmedName, $duplicateFields)) {
                            $duplicateFields[] = 'ชื่อผู้ใช้ที่ซ้ำในไฟล์ xlsx: ' . $trimmedName;
                        }
                        $Ceas = trim($rowsss[7]);
                        if (in_array($Ceas, $duplicateFields)) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ในไฟล์ xlsx: ' . $Ceas;
                        }
                        if (DB::table('users')
                            ->where('username', trim($rowsss[1]))->exists()
                        ) {
                            $duplicateFields[] = 'ชื่อผู้ใช้ซ้ำในระบบ: ' . trim($rowsss[1]);
                        }

                        if (DB::table('users')
                            ->where('citizen_id', trim($rowsss[7]))->exists()
                        ) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ระบบ: ' . trim($rowsss[7]);
                        }
                    }
                }

                if (!empty($duplicateFields)) {
                    return response()->json(['error' => implode("\n", $duplicateFields)], 200);
                }
                $Usertimestamp =  now()->timestamp . '00';
                foreach ($importedDataUser[0] as $row) {
                    $duplicateFields = [];

                    if ($row[0] == 'ลำดับ') {
                        continue;
                    }

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

                        $Usertimestamp += 1;

                        $newUsers = new Users([
                            'user_id' =>  $Usertimestamp,
                            'username' => trim($row[1]),
                            'password' => Hash::make($row[2]),
                            'firstname' => $row[3],
                            'lastname' => $row[4],
                            'mobile' => $row[5],
                            'email' => $row[6],
                            'citizen_id' =>   trim($row[7]),
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
                            'user_affiliation' =>  $row[9] ?? null,
                        ]);

                        $newUsers->save();
                    }
                }

                return response()->json(['message' => 'Import successfully'], 200);
            } else {
                return response()->json(['error' => 'No data found in the imported file']);
            }
        } else {
            return response()->json(['error' => 'No file uploaded']);
        }
    }
    public function UsersDepartImports(Request $request, $department_id)
    {
        $UserDepartimport = new UserDepartimport($department_id);

        if ($request->hasFile('fileexcel')) {

            $importedDataUser = Excel::toArray($UserDepartimport, $request->file('fileexcel'));
            if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
                // มีข้อมูลที่นำเข้า
                $duplicateFields = [];

                foreach ($importedDataUser[0] as $rowsss) {
                    if ($rowsss[0] == 'ลำดับ') {
                        continue;
                    }
                    if ($rowsss[0] >= 1) {
                        if (empty(trim($rowsss[7]))) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนไม่สามารถเป็นค่าว่างได้';
                        }
                        $trimmedName = trim($rowsss[1]);
                        if (in_array($trimmedName, $duplicateFields)) {
                            $duplicateFields[] = 'ชื่อผู้ใช้ที่ซ้ำในไฟล์ xlsx: ' . $trimmedName;
                        }
                        $Ceas = trim($rowsss[7]);
                        if (in_array($Ceas, $duplicateFields)) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ในไฟล์ xlsx: ' . $Ceas;
                        }
                        if (DB::table('users')
                            ->where('username', trim($rowsss[1]))->exists()
                        ) {
                            $duplicateFields[] = 'ชื่อผู้ใช้ซ้ำในระบบ: ' . trim($rowsss[1]);
                        }

                        if (DB::table('users')
                            ->where('citizen_id', trim($rowsss[7]))->exists()
                        ) {
                            $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ระบบ: ' . trim($rowsss[7]);
                        }
                    }
                }
                if (!empty($duplicateFields)) {
                    return response()->json(['error' => implode("\n", $duplicateFields)], 200);
                }
                $Usertimestamp =  now()->timestamp . '00';
                foreach ($importedDataUser[0] as $row) {
                    if ($row[0] == 'ลำดับ') {
                        continue;
                    }

                    if ($row[0] >= 1) {
                        $user_idplus = Users::max('user_id') ?? 0;
                        $uiduserdepartment_id = UserDepartment::max('user_department_id') ?? 0;
                        $user_role = 4;
                        $prefix = null;
                        $per_id = null;
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


                        $Usertimestamp += 1;

                        $newUsers = new Users([
                            'user_id' => $Usertimestamp,
                            'username' => trim($row[1]),
                            'password' => Hash::make($row[2]),
                            'firstname' => $row[3],
                            'lastname' => $row[4],
                            'mobile' => $row[5],
                            'email' => $row[6],
                            'citizen_id' =>   trim($row[7]),
                            'prefix' =>  $prefix,
                            'gender' => $row[8] ?? null,
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
                            'user_affiliation' =>  $row[9] ?? null,
                        ]);

                        $UserDepartment =  new UserDepartment([
                            'user_department_id' =>  $Usertimestamp,
                            'user_id' =>    $newUsers->user_id,
                            'department_id' => $department_id,

                        ]);
                        if ($department_id == 1) {
                            $UserDepartment2 =  new UserDepartment([

                                'user_department_id' =>  $Usertimestamp,
                                'user_id' => $newUsers->user_id,
                                'department_id' => 2,

                            ]);
                            $UserDepartment2->save();
                        } elseif ($department_id == 2) {
                            $UserDepartment3 =  new UserDepartment([

                                'user_department_id' =>  $Usertimestamp,
                                'user_id' => $newUsers->user_id,
                                'department_id' => 1,

                            ]);
                            $UserDepartment3->save();
                        }

                        $UserDepartment->save();
                        $newUsers->save();
                    }
                }

                if (!empty($validationErrors)) {
                    return response()->json(['error' => implode("\n", $validationErrors)], 200);
                }

                return response()->json(['message' => 'Import successfully'], 200);
            } else {
                return response()->json(['error' => 'No data found in the imported file']);
            }
        } else {
            return response()->json(['error' => 'No file uploaded']);
        }
    }
    public function UsersDepartImport(Request $request, $department_id)
    {

        if ($request->hasFile('fileexcel')) {
            $UserDepartimport = new UserDepartimport($department_id);

            $importedDataUser = Excel::toArray($UserDepartimport, $request->file('fileexcel'));
            if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
                // มีข้อมูลที่นำเข้า
                $Fields = [];

                foreach ($importedDataUser[0] as $rowsss) {
                    if ($rowsss[0] == 'ลำดับ') {
                        continue;
                    }
                    if ($rowsss[0] >= 1) {
                        $username = trim($rowsss[1]);
                        $username = preg_replace('/[ก-๙]+/u', '', $username);
                        $field = [
                            'username' => $username,
                            'password' =>  strval($rowsss[2]),
                            'firstname' => $rowsss[3],
                            'lastname' => $rowsss[4],
                            'tele' => trim($rowsss[5]),
                            'email' => $rowsss[6],
                            'citizen' => strval(trim($rowsss[7])),
                            'gerder' => $rowsss[8],
                            'pro' => $rowsss[9],
                            'province' => $request->input('provin'),
                            'distrits' => $request->input('distrits'),
                            'subdistrits' => $request->input('subdistrits'),
                        ];

                        $Fields[] = $field;
                    }
                }

                $existingUsernames = [];
                $duplicateUsernames = [];

                foreach ($Fields as $field) {


                    if (in_array($field['username'], $existingUsernames)) {
                        $duplicateUsernames[] = 'ชื่อผู้ใช้ที่ซ้ำในไฟล์ xlsx: ' .  $field['username'];
                    } elseif (strlen($field['username']) < 8) {
                        $duplicateUsernames[] = 'ชื่อไม่ต่ำกว่า 8 ตัวอักษรในไฟล์ xlsx: ' .  $field['username'];
                    } elseif (preg_match('/[ก-๙]/u', $field['username'])) {
                        $duplicateUsernames[] = 'ชื่อต้องไม่เป็นภาษาไทยในไฟล์ xlsx: ' .  $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }


                    if (in_array($field['citizen'], $existingUsernames)) {

                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนซ้ำ ในไฟล์ xlsx: ' .  $field['citizen'];
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                    if (empty($field['citizen'])) {
                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนไม่สามารถเป็นค่าว่างได้';
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                    if (DB::table('users')
                        ->where('username', $field['username'])->exists()
                    ) {
                        $duplicateUsernames[] = 'ชื่อผู้ใช้ซ้ำในระบบ: ' . $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }
                    if (DB::table('users')
                        ->where('citizen_id', $field['citizen'])->exists()
                    ) {
                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนซ้ำ ระบบ: ' .  $field['citizen'];
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                }

                if (!empty($duplicateUsernames)) {
                    return response()->json(['error' => 'ข้อมูลซ้ำกัน: ' . implode("\n", $duplicateUsernames)], 200);
                } else {
                    $Usertimestamp =  now()->timestamp . '00';
                    $insertedCount = 0;
                    foreach ($Fields as $row) {


                        $user_role = 4;
                        $prefix = null;
                        $per_id = null;
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

                        $recoverpassword = null;
                        $employeecode = null;

                        $Usertimestamp += 1;

                        $newUsers = new Users([
                            'user_id' => $Usertimestamp,
                            'username' => $row['username'],
                            'password' => Hash::make(strval($row['password'])),
                            'firstname' => $row['firstname'],
                            'lastname' => $row['lastname'],
                            'mobile' => $row['tele'],
                            'email' => $row['email'],
                            'citizen_id' =>   strval($row['citizen']),
                            'gender' => $row['gender'] ?? null,
                            'prefix' =>  $prefix,
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
                            'province_id' => 0,
                            'district_id' => 0,
                            'subdistrict_id' =>  0,
                            'recoverpassword' =>  $recoverpassword,
                            'employeecode' =>  $employeecode,
                            'organization' =>  0,
                            'user_affiliation' =>  $row['pro'] ?? null,
                            'user_type_card' =>  0,
                            'birthday' => null,
                        ]);
                        $newUsers->save();
                        $insertedCount++;
                        $UserDepartment =  new UserDepartment([
                            'user_department_id' =>  $Usertimestamp,
                            'user_id' =>    $newUsers->user_id,
                            'department_id' => $department_id,
                        ]);
                        $UserDepartment->save();
                    }

                    return response()->json(['message' => 'Import successfully', 'inserted_count' => $insertedCount], 200);
                }
            } else {
                return response()->json(['error' => 'No data found in the imported file']);
            }
        } else {
            return response()->json(['error' => 'No file uploaded']);
        }
    }
    public function UsersDepartSchoolImport(Request $request, $department_id,  $extender_id)
    {

        if ($request->hasFile('fileexcel')) {
            $UserDepartimport = new SchoolDpimportClass($department_id, $extender_id);

            $importedDataUser = Excel::toArray($UserDepartimport, $request->file('fileexcel'));
            if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
                // มีข้อมูลที่นำเข้า
                $Fields = [];

                foreach ($importedDataUser[0] as $rowsss) {
                    if ($rowsss[0] == 'ลำดับ') {
                        continue;
                    }
                    if ($rowsss[0] >= 1) {
                        $username = trim($rowsss[1]);
                        $username = preg_replace('/[ก-๙]+/u', '', $username);
                        $field = [
                            'username' => $username,
                            'password' =>  strval($rowsss[2]),
                            'firstname' => $rowsss[3],
                            'lastname' => $rowsss[4],
                            'tele' => trim($rowsss[5]),
                            'email' => $rowsss[6],
                            'citizen' => strval(trim($rowsss[7])),
                            'gerder' => $rowsss[8],
                            'pro' => $rowsss[9],
                        ];

                        $Fields[] = $field;
                    }
                }

                $existingUsernames = [];
                $duplicateUsernames = [];

                foreach ($Fields as $field) {

                    if (in_array($field['username'], $existingUsernames)) {
                        $duplicateUsernames[] = 'ชื่อผู้ใช้ที่ซ้ำในไฟล์ xlsx: ' .  $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }

                    if (strlen($field['username']) < 8) {
                        $duplicateUsernames[] = 'ชื่อไม่ต่ำกว่า 8 ตัวอักษรในไฟล์ xlsx: ' .  $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }
                    if (preg_match('/[ก-๙]/u', $field['username'])) {
                        $duplicateUsernames[] = 'ชื่อต้องไม่เป็นภาษาไทยในไฟล์ xlsx: ' .  $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }
                    if (in_array($field['citizen'], $existingUsernames)) {

                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนซ้ำ ในไฟล์ xlsx: ' .  $field['citizen'];
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                    if (empty($field['citizen'])) {
                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนไม่สามารถเป็นค่าว่างได้';
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                    if (DB::table('users')
                        ->where('username', $field['username'])->exists()
                    ) {
                        $duplicateUsernames[] = 'ชื่อผู้ใช้ซ้ำในระบบ: ' . $field['username'];
                    } else {
                        $existingUsernames[] = $field['username'];
                    }
                    if (DB::table('users')
                        ->where('citizen_id', $field['citizen'])->exists()
                    ) {
                        $duplicateUsernames[] = 'รหัสประจำตัวประชาชนซ้ำ ระบบ: ' .  $field['citizen'];
                    } else {
                        $existingUsernames[] = $field['citizen'];
                    }
                }

                if (!empty($duplicateUsernames)) {
                    return response()->json(['error' => 'ข้อมูลซ้ำกัน: ' . implode("\n", $duplicateUsernames)], 200);
                } else {
                    $Usertimestamp =  now()->timestamp . '00';
                    $insertedCount = 0;
                    foreach ($Fields as $row) {

                        $extende2 = Extender2::findOrFail($extender_id);
                        $user_role = 4;
                        $prefix = null;
                        $per_id = null;
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
                        $province_id = $extende2->school_province;
                        $district_id = $extende2->school_district;
                        $subdistrict_id = $extende2->school_subdistrict;
                        $recoverpassword = null;
                        $employeecode = null;

                        $Usertimestamp += 1;

                        $newUsers = new Users([
                            'user_id' => $Usertimestamp,
                            'username' => $row['username'],
                            'password' => Hash::make(strval($row['password'])),
                            'firstname' => $row['firstname'],
                            'lastname' => $row['lastname'],
                            'mobile' => $row['tele'],
                            'email' => $row['email'],
                            'citizen_id' =>   strval($row['citizen']),
                            'gender' => $row['gender'] ?? null,
                            'prefix' =>  $prefix,
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
                            'organization' =>  $extender_id,
                            'user_affiliation' =>  $row['pro'] ?? null,
                            'user_type_card' =>  0,
                            'birthday' => null,
                        ]);
                        $newUsers->save();
                        $insertedCount++;
                        $UserDepartment =  new UserDepartment([
                            'user_department_id' =>  $Usertimestamp,
                            'user_id' =>    $newUsers->user_id,
                            'department_id' => $department_id,
                        ]);
                        $UserDepartment->save();
                    }

                    return response()->json(['message' => 'Import successfully', 'inserted_count' => $insertedCount], 200);
                }
            } else {
                return response()->json(['error' => 'No data found in the imported file']);
            }
        } else {
            return response()->json(['error' => 'No file uploaded']);
        }
    }
    // public function UsersDepartSchoolImport2(Request $request, $department_id,  $extender_id)
    // {

    //     if ($request->hasFile('fileexcel')) {
    //         $UserDepartimport = new SchoolDpimportClass($department_id, $extender_id);
    //         $importedDataUser = Excel::toArray($UserDepartimport, $request->file('fileexcel'));
    //         if (count($importedDataUser) > 0 && count($importedDataUser[0]) > 0) {
    //             // มีข้อมูลที่นำเข้า
    //             $duplicateFields = [];

    //             foreach ($importedDataUser[0] as $rowsss) {
    //                 if ($rowsss[0] == 'ลำดับ') {
    //                     continue;
    //                 }
    //                 if ($rowsss[0] >= 1) {
    //                     if (empty(trim($rowsss[7]))) {
    //                         $duplicateFields[] = 'รหัสประจำตัวประชาชนไม่สามารถเป็นค่าว่างได้';
    //                     }
    //                     $trimmedName = trim($rowsss[1]);

    //                     if (isset($duplicateFields[$trimmedName])) {
    //                         $duplicateFields[$trimmedName] = 'ชื่อผู้ใช้ที่ซ้ำในไฟล์ xlsx: ' . $trimmedName;
    //                     }
    //                     $Ceas = trim($rowsss[7]);
    //                     if (in_array($Ceas, $duplicateFields)) {
    //                         $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ในไฟล์ xlsx: ' . $Ceas;
    //                     }
    //                     if (DB::table('users')
    //                         ->where('username', trim($rowsss[1]))->exists()
    //                     ) {
    //                         $duplicateFields[] = 'ชื่อผู้ใช้ซ้ำในระบบ: ' . trim($rowsss[1]);
    //                     }

    //                     if (DB::table('users')
    //                         ->where('citizen_id', trim($rowsss[7]))->exists()
    //                     ) {
    //                         $duplicateFields[] = 'รหัสประจำตัวประชาชนซ้ำ ระบบ: ' . trim($rowsss[7]);
    //                     }
    //                 }
    //             }
    //             if (!empty($duplicateFields)) {
    //                 return response()->json(['error' => implode("\n", $duplicateFields)], 200);
    //             }
    //             $Usertimestamp =  now()->timestamp . '00';
    //             $insertedCount = 0;
    //             foreach ($importedDataUser[0] as $row) {

    //                 if ($row[0] == 'ลำดับ') {
    //                     continue;
    //                 }
    //                 if ($row[0] >= 1) {
    //                     $user_idplus = DB::table('users')->max('user_id') ?? 0;
    //                     $uiduserdepartment_id = DB::table('users_department')->max('user_department_id') ?? 0;
    //                     $extende2 = Extender2::findOrFail($extender_id);
    //                     $user_role = 4;
    //                     $prefix = null;
    //                     $per_id = null;
    //                     $permission = null;
    //                     $ldap = 0;
    //                     $userstatus = 1;
    //                     $createdate = now();
    //                     $createby = 2;
    //                     $avatar = '';
    //                     $user_position = '';
    //                     $workplace = '';
    //                     $telephone = '';
    //                     $socialnetwork = '';
    //                     $experience = null;
    //                     $recommened = null;
    //                     $templete = null;
    //                     $nickname = '';
    //                     $introduce = '';
    //                     $bgcustom = '';
    //                     $pay = '';
    //                     $education = '';
    //                     $teach = '';
    //                     $modern = '';
    //                     $other = '';
    //                     $profiles = null;
    //                     $editflag = null;
    //                     $pos_level = 0;
    //                     $pos_name = '';
    //                     $sector_id = 0;
    //                     $office_id = 0;
    //                     $user_type = null;
    //                     $province_id = $extende2->school_province;
    //                     $district_id = $extende2->school_district;
    //                     $subdistrict_id = $extende2->school_subdistrict;
    //                     $recoverpassword = null;
    //                     $employeecode = null;

    //                     $Usertimestamp += 1;

    //                     $newUsers = new Users([
    //                         'user_id' => $Usertimestamp,
    //                         'username' => trim($row[1]),
    //                         'password' => Hash::make($row[2]),
    //                         'firstname' => $row[3],
    //                         'lastname' => $row[4],
    //                         'mobile' => $row[5],
    //                         'email' => $row[6],
    //                         'citizen_id' =>   trim($row[7]),
    //                         'gender' => $row[8] ?? null,
    //                         'prefix' =>  $prefix,
    //                         'user_role' => $user_role,
    //                         'per_id' => $per_id,
    //                         'department_id' => $department_id,
    //                         'permission' => $permission,
    //                         'ldap' => $ldap,
    //                         'userstatus' => $userstatus,
    //                         'createdate' => $createdate,
    //                         'createby' => $createby,
    //                         'avatar' => $avatar,
    //                         'user_position' =>  $user_position,
    //                         'workplace' =>  $workplace,
    //                         'telephone' =>  $telephone,
    //                         'socialnetwork' =>  $socialnetwork,
    //                         'experience' =>  $experience,
    //                         'recommened' => $recommened,
    //                         'templete' => $templete,
    //                         'nickname' =>  $nickname,
    //                         'introduce' => $introduce,
    //                         'bgcustom' =>  $bgcustom,
    //                         'pay' =>  $pay,
    //                         'education' => $education,
    //                         'teach' => $teach,
    //                         'modern' => $modern,
    //                         'other' => $other,
    //                         'profiles' =>  $profiles,
    //                         'editflag' => $editflag,
    //                         'pos_level' => $pos_level,
    //                         'pos_name' => $pos_name,
    //                         'sector_id' =>  $sector_id,
    //                         'office_id' => $office_id,
    //                         'user_type' => $user_type,
    //                         'province_id' => $province_id,
    //                         'district_id' => $district_id,
    //                         'subdistrict_id' =>  $subdistrict_id,
    //                         'recoverpassword' =>  $recoverpassword,
    //                         'employeecode' =>  $employeecode,
    //                         'organization' =>  $extender_id,
    //                         'user_affiliation' =>  $row[9] ?? null,
    //                         'user_type_card' =>  0,
    //                         'birthday' => null,
    //                     ]);
    //                     $newUsers->save();
    //                     $insertedCount++;
    //                     $UserDepartment =  new UserDepartment([
    //                         'user_department_id' =>  $Usertimestamp,
    //                         'user_id' =>    $newUsers->user_id,
    //                         'department_id' => $department_id,
    //                     ]);
    //                     $UserDepartment->save();
    //                 }
    //             }

    //             return response()->json(['message' => 'Import successfully', 'inserted_count' => $insertedCount], 200);
    //         } else {
    //             return response()->json(['error' => 'No data found in the imported file']);
    //         }
    //     } else {
    //         return response()->json(['error' => 'No file uploaded']);
    //     }
    // }
}
