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
                'provinces.id as province_id',
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
                'provinces.id as province_id',
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
                'provinces.id as province_id',
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
                'provinces.id as province_id',
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
        $registerdate = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('users.user_role', '=', 4)

            ->select(
                'provinces.id as province_id',
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                DB::raw('COUNT(users.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM users.createdate)')
            )
            ->get();

        $monthsYear = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->where('users.user_role', '=', 4)
            ->where('provinces.id', '=', 2)
            ->select(
                'provinces.id as province_id',
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                DB::raw('TO_CHAR(users.createdate, \'MM\') as month'),
                DB::raw('COUNT(users.user_id) as user_count')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('TO_CHAR(users.createdate, \'MM\')'),
                DB::raw('EXTRACT(YEAR FROM users.createdate)')
            )
            ->get();
                // dd($monthsYear);

        $dataMonthWithId = [
            ['id' => 1, 'month' => 'มกราคม', 'sort' => 4],
            ['id' => 2, 'month' => 'กุมภาพันธ์', 'sort' => 5],
            ['id' => 3, 'month' => 'มีนาคม', 'sort' => 6],
            ['id' => 4, 'month' => 'เมษายน', 'sort' => 7],
            ['id' => 5, 'month' => 'พฤษภาคม', 'sort' => 8],
            ['id' => 6, 'month' => 'มิถุนายน', 'sort' => 9],
            ['id' => 7, 'month' => 'กรกฎาคม', 'sort' => 10],
            ['id' => 8, 'month' => 'สิงหาคม', 'sort' => 11],
            ['id' => 9, 'month' => 'กันยายน', 'sort' => 12],
            ['id' => 10, 'month' => 'ตุลาคม', 'sort' => 1],
            ['id' => 11, 'month' => 'พฤศจิกายน', 'sort' => 2],
            ['id' => 12, 'month' => 'ธันวาคม', 'sort' => 3],
        ];




        $dateAll = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));


        return view(
            'page.report2.A.reporta',
            compact('registerdate', 'monthsYear', 'dateAll',  'dataMonthWithId', 'provin', 'dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'learn', 'con', 'conno')
        );
    }
}
