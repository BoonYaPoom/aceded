<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\CourseLearner;
use App\Models\PersonType;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAController extends Controller
{
    public function Reportview()
    {


        return view('page.report2.index');
    }

    public function ReportA()
    {
        $provin = DB::table('provinces')->get();
        $count1 = DB::table('users')->whereIn('user_role', [1, 6, 7, 8, 9])->count();
        $count3 = DB::table('users')->where('user_role', 3)->count();
        $count4 = DB::table('users')->where('user_role', 4)->count();
        $user_role1 = DB::table('users')->where('user_role', 1)->first();
        $user_role3 = DB::table('users')->where('user_role', 3)->first();
        $user_role4 = DB::table('users')->where('user_role', 4)->first();
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

        $con = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 1)
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

        $combinedResult = $learn->merge($con);
        $conno = $learn->map(function ($item) use ($con) {
            $matchingItem = $con->firstWhere(function ($conItem) use ($item) {
                return $conItem->year == $item->year && $conItem->province_name == $item->province_name;
            });

            return [
                'year' => $item->year,
                'province_name' => $item->province_name,
                'user_count' => abs(
                    $item->user_count - ($matchingItem ? $matchingItem->user_count : 0)
                ),
            ];
        });



        $monthsconno = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 0)
            ->select(
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\') as month'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\')')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
        $monthscon = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 1)
            ->select(
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\') as month'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\')')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();



        $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));


        return view(
            'page.report2.A.reporta',
            compact('dateAll', 'provin', 'dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'learn', 'con', 'conno')
        );
    }
}
