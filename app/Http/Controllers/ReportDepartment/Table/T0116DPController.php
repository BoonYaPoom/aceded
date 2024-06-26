<?php

namespace App\Http\Controllers\ReportDepartment\Table;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class T0116DPController extends Controller
{
    public function T0116DP($department_id)
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
        $depart = Department::findOrFail($department_id);
        $learner = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->where('users_department.department_id', '=', $department_id)
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
            ->select(
                'users.username',
                'users.firstname',
                'users.lastname',
                'department.name_th',
                'users_department.department_id',
                'users_extender2.name as exten_name',
                'course.course_th as course_th',
                'provinces.name_in_thai as province_name',
                'course_learner.congratulation as congratulation',
                DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as register_date"),
                DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as realcongratulationdate"),
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
            )->distinct()
            ->get();
        return view('layouts.department.item.data.report2.C.table.t0116dp', compact('month', 'provin', 'learner', 'depart'));
    }


    function P0116DP($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();

        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $provins = $data->province_id;
            $zones = DB::table('user_admin_zone')->where('user_id', $data->user_id)->pluck('province_id')->toArray();
            $provinceIds = implode(',', array_map('intval', $zones));
            if ($data->user_role == 7) {
                $sql = "SELECT DISTINCT
                            users.username,
                            users.firstname,
                            users.lastname,
                            department.name_th AS department_name,
                            users_department.department_id,
                            CASE
                                WHEN users_department.department_id > 5 THEN users.USER_affiliation
                                ELSE users_extender2.name
                            END AS exten_name,
                            course.course_th AS course_th,
                            provinces.name_in_thai AS province_name,
                            TO_CHAR(course_learner.registerdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS register_date,
                            TO_CHAR(course_learner.realcongratulationdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS realcongratulationdate,
                            EXTRACT(YEAR FROM course_learner.registerdate) + 543 AS year
                        FROM
                            users
                        JOIN
                            course_learner ON TO_NUMBER(users.user_id) = TO_NUMBER(course_learner.user_id)
                        JOIN
                            users_department ON TO_NUMBER(users.user_id) = TO_NUMBER(users_department.user_id)
                        JOIN
                            department ON TO_NUMBER(users_department.department_id) = TO_NUMBER(department.department_id)
                        JOIN
                            provinces ON TO_NUMBER(users.province_id) = TO_NUMBER(provinces.id)
                        JOIN
                            course ON TO_NUMBER(course_learner.course_id) = TO_NUMBER(course.course_id)
                            LEFT JOIN
                            users_extender2 ON users_department.department_id < 5 AND TO_NUMBER(users.organization) = TO_NUMBER(users_extender2.extender_id)
                        WHERE
                            course_learner.learner_status = 1
                            AND users.user_role = 4
                            AND course_learner.course_id > 0
                            AND users_department.department_id = :department_id
                            AND users.province_id = :province_id";
                $bindings = [
                    'department_id' => $department_id,
                    'province_id' => $data->province_id,
                ];

                $learner = collect(DB::select($sql, $bindings));
            } elseif ($data->user_role == 9) {
                $sql = "SELECT DISTINCT
                            users.username,
                            users.firstname,
                            users.lastname,
                            department.name_th AS department_name,
                            users_department.department_id,
                            CASE
                                WHEN users_department.department_id > 5 THEN users.USER_affiliation
                                ELSE users_extender2.name
                            END AS exten_name,
                            course.course_th AS course_th,
                            provinces.name_in_thai AS province_name,
                            TO_CHAR(course_learner.registerdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS register_date,
                            TO_CHAR(course_learner.realcongratulationdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS realcongratulationdate,
                            EXTRACT(YEAR FROM course_learner.registerdate) + 543 AS year
                        FROM
                            users
                        JOIN
                            course_learner ON TO_NUMBER(users.user_id) = TO_NUMBER(course_learner.user_id)
                        JOIN
                            users_department ON TO_NUMBER(users.user_id) = TO_NUMBER(users_department.user_id)
                        JOIN
                            department ON TO_NUMBER(users_department.department_id) = TO_NUMBER(department.department_id)
                        JOIN
                            provinces ON TO_NUMBER(users.province_id) = TO_NUMBER(provinces.id)
                        JOIN
                            course ON TO_NUMBER(course_learner.course_id) = TO_NUMBER(course.course_id)
                            LEFT JOIN
                            users_extender2 ON users_department.department_id < 5 AND TO_NUMBER(users.organization) = TO_NUMBER(users_extender2.extender_id)
                        WHERE
                            course_learner.learner_status = 1
                            AND users.user_role = 4
                            AND course_learner.course_id > 0
                            AND users_department.department_id = :department_id
                            AND users.province_id IN ($provinceIds)";
                $bindings = [
                    'department_id' => $department_id,
                ];

                $learner = collect(DB::select($sql, $bindings));
            }
        }
        return view('layouts.department.item.data.report2.C.table.p0116dp', compact('month', 'learner', 'provin', 'depart'));
    }
}
