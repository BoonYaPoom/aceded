<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportBController extends Controller
{
    public function ReportB()
    {
        $learn = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->select(
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)')
            )
            ->get();

        $organization = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->where('users_department.department_id', '=', 5)
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->select(
                'users_extender2.name as exten_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'users_extender2.extender_id',
                'users_extender2.name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)')
            )
            ->get();
        $aff = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->where('users_department.department_id', '=', 6)
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)

            ->select(
                'users.user_affiliation as aff_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'users.user_affiliation',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)')
            )
            ->get();
        $organi4 = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->where('users_department.department_id', '=', 4)
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->select(
                'users_extender2.name as exten_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'users_extender2.extender_id',
                'users_extender2.name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)')
            )
            ->get();
        return view('page.report2.B.reportb', compact('learn', 'organization', 'aff', 'organi4'));
    }
}
