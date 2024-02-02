<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0101Controller extends Controller
{
    public function T0101()
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $learner = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
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
                DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as register_date"),
                DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as realcongratulationdate"),
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
            )->distinct()
            ->get();


        return view('page.report2.C.Table.T0101', compact('month', 'learner'));
    }
}
