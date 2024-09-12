<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0101Controller extends Controller
{
    public function T01012()
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
        // $learners = DB::table('users')
        //     ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
        //     ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
        //     ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
        //     ->join('department', 'users_department.department_id', '=', 'department.department_id')
        //     ->join('provinces', 'users.province_id', '=', 'provinces.id')
        //     ->join('course', 'course_learner.course_id', '=', 'course.course_id')
        //     ->where('course_learner.learner_status', '=', 1)
        //     ->where('users.user_role', 4)
        //     ->where('course_learner.course_id', '>', 0)

        //     ->select(
        //         'users.username',
        //         'users.firstname',
        //         'users.lastname',
        //         'department.name_th',
        //         'users_department.department_id',
        //         'users_extender2.name as exten_name',
        //         'course.course_th as course_th',
        //         'provinces.name_in_thai as province_name',
        //         DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as register_date"),
        //         DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as realcongratulationdate"),
        //         DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
        //     )->distinct()
        //     ->get();


        $sql = "SELECT DISTINCT
                            users.username,
                            users.firstname,
                            users.lastname,
                            department.name_th AS department_name,
                            users_department.department_id,
                            course_learner.congratulation as congratulation,
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
                            course_learner ON users.user_id = course_learner.user_id
                        JOIN
                            users_department ON users.user_id = users_department.user_id
                        JOIN
                            department ON users_department.department_id = department.department_id
                        JOIN
                            provinces ON users.province_id = provinces.id
                        JOIN
                            course ON course_learner.course_id = course.course_id
                            LEFT JOIN
                            users_extender2 ON users_department.department_id < 5 AND users.organization = users_extender2.extender_id
                        WHERE
                            course_learner.learner_status = 1
                            AND users.user_role = 4
                            AND course_learner.course_id > 0
                        ";
        $learner = collect(DB::select($sql));




        return view('page.report.tables.t0101', compact('month', 'learner', 'provin'));
    }
    public function T0101()
    {
        $provin = DB::table('provinces')->get();
     


        return view('page.report2.C.table.t0101', compact( 'provin'));
    }


    public function T0101api($year, $provin)
    {
        $sql = "SELECT DISTINCT
                users.username,
                users.firstname,
                users.lastname,
                department.name_th AS department_name,
                users_department.department_id,
                course_learner.congratulation as congratulation,
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
                course_learner ON users.user_id = course_learner.user_id
            JOIN
                users_department ON users.user_id = users_department.user_id
            JOIN
                department ON users_department.department_id = department.department_id
            JOIN
                provinces ON users.province_id = provinces.id
            JOIN
                course ON course_learner.course_id = course.course_id
            LEFT JOIN
                users_extender2 ON users_department.department_id < 5 AND users.organization = users_extender2.extender_id
            WHERE
                course_learner.learner_status = 1
                AND users.user_role = 4
                AND course_learner.course_id > 0
                AND EXTRACT(YEAR FROM course_learner.registerdate) + 543 = :year
                AND provinces.id = :provin";


        $learner = DB::select($sql, [
            'year' => $year,
            'provin' => $provin
        ]);

        return response()->json($learner);
    }
}
