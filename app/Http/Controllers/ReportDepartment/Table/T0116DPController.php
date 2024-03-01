<?php

namespace App\Http\Controllers\ReportDepartment\Table;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
