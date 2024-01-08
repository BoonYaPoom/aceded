<?php

namespace App\Http\Controllers;

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

        $count1 = DB::table('users')->where('user_role', 1)->count();
        $count3 = DB::table('users')->where('user_role', 3)->count();
        $count4 = DB::table('users')->where('user_role', 4)->count();
        $user_role1 = DB::table('users')->where('user_role', 1)->first();
        $user_role3 = DB::table('users')->where('user_role', 3)->first();
        $user_role4 = DB::table('users')->where('user_role', 4)->first();

        $learn = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->where('course_learner.learner_status', '=', 1)
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
        $con = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 1)
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')

            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
        $conno = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 0)
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
        $monthsconno = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 0)
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\') as month'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(DB::raw('TO_CHAR(course_learner.registerdate, \'MM\')'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
        $monthscon = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.congratulation', '=', 1)
            ->select(
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('TO_CHAR(course_learner.registerdate, \'MM\') as month'),
                DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
            )
            ->groupBy(DB::raw('TO_CHAR(course_learner.registerdate, \'MM\')'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();



        $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));

        $chartDataCon = [];
        $chartDataCon2 = [];

      

        foreach ($dateAllWithId as $monthWithId) {

            $monthId = $monthWithId['id'];
            $matchingMonth = null;
            $matchingMonth2 = null;
            foreach ($monthscon as $monthData) {
                if ($monthData->month == $monthId) {
                    $matchingMonth = $monthData;
                    break;
                }
            }
            $chartDataCon[$monthId] = [
                'year' => $matchingMonth ? $matchingMonth->year : null,
                'user_count' => $matchingMonth ? $matchingMonth->user_count : 0,
            ];
            foreach ($monthsconno as $monthData2) {
                if ($monthData2->month == $monthId) {
                    $matchingMonth2 = $monthData2;
                    break;
                }
            }
            $chartDataCon2[$monthId] = [
                'year' => $matchingMonth2 ? $matchingMonth2->year : null,
                'user_count' => $matchingMonth2 ? $matchingMonth2->user_count : 0,
            ];
        }

        for ($monthNumber = 1; $monthNumber <= 12; $monthNumber++) {
            if (!isset($chartDataCon[$monthNumber])) {
                $chartDataCon[$monthNumber] = [
                    'year' => null,
                    'user_count' => 0,
                ];
            }
            if (!isset($chartDataCon2[$monthNumber])) {
                $chartDataCon2[$monthNumber] = [
                    'year' => null,
                    'user_count' => 0,
                ];
            }
        }

     
        return view('page.report2.reporta', compact('chartDataCon', 'chartDataCon2', 'dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'user_role4', 'user_role1', 'user_role3', 'learn', 'con', 'conno'));
    }
}
