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

        return view('page.report2.B.reportb', compact('learn'));
    }
}
