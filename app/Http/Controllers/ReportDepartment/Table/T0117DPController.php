<?php

namespace App\Http\Controllers\ReportDepartment\Table;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0117DPController extends Controller
{
    public function T0117DP($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
        $learner
            = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->where('users_department.department_id', '=', $department_id)
            ->where('department.department_id', '=', $department_id)
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
        
            ->select(
                'department.department_id',
                'course.course_th as course_th',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
            )
            ->groupBy(
                'department.department_id',
                'course.course_th',
                'department.name_th',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate) + 543')
            )
            ->orderBy('department.department_id', 'ASC')
            ->get();

        return view('layouts.department.item.data.report2.C.table.t0117dp', compact('month', 'provin', 'learner', 'depart'));
    }
}
