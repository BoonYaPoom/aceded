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
            ->where('course_learner.learner_status', '=', 1)
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate) + 543 as year'),
                'provinces.name_in_thai as province_name',
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)')
            )
            ->whereIn(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate) + 543'), [2566, 2567])
            ->orderBy('year')
            ->orderBy('user_count', 'desc')
            ->get();

        $enss = DB::table('users')
            ->join('users_extender2.extender_id', '=', 'users.orgenazation')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id');



        return view('page.report2.B.reportb', compact('learn'));
    }
}
