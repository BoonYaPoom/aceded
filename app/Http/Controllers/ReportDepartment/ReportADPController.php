<?php

namespace App\Http\Controllers\ReportDepartment;

use App\Http\Controllers\Controller;
use App\Models\CourseLearner;
use App\Models\Department;
use App\Models\PersonType;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportADPController extends Controller
{
    public function Reportview($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('layouts.department.item.data.report2.index', compact('depart'));
    }
    public function ReportA($department_id)
    {
        $depart = Department::findOrFail($department_id);
        // $userIds = DB::table('users_department')
        //     ->where('department_id', $department_id)
        //     ->pluck('user_id')
        //     ->toArray();
        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;
            $provins = $data->province_id;
            $provinceData = DB::table('provinces')
                ->where('id', $provins)
                ->select('name_in_thai')
                ->first();

            $count1 = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('user_role', 1);
            $count3 = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('user_role', 3);
            $count4 = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('user_role', 4);
            $learn = DB::table('users')
                ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('course_learner.learner_status', '=', 1)
                ->select(
                    DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                    DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
                )
                ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
            $con = DB::table('users')
                ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('course_learner.learner_status', '=', 1)
                ->where('course_learner.congratulation', '=', 1)
                ->select(
                    DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                    DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count'),
                    DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                )
                ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
            ->get();
            $conno = DB::table('users')

                ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
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
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
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
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
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
            if ($data->user_role == 1 || $data->user_role == 8) {
                $count1;
                $count3;
                $count4;
                $learn;
                $con;
                $conno;
                $monthscon;
                $monthsconno;
            } elseif ($data->user_role == 7) {
                $count1->where('users.province_id', '=', $provins);
                $count3->where('users.province_id', '=', $provins);
                $count4->where('users.province_id', '=', $provins);
                $learn->where('users.province_id', '=', $provins);
                $con->where('users.province_id', '=', $provins);
                $conno->where('users.province_id', '=', $provins);
                $monthscon->where('users.province_id', '=', $provins);
                $monthsconno->where('users.province_id', '=', $provins);
             
            } elseif ($data->user_role == 6) {
                $count1->where('users.organization', '=', $orgs);
                $count3->where('users.organization', '=', $orgs);
                $count4->where('users.organization', '=', $orgs);
                $learn->where('users.organization', '=', $orgs);
                $con->where('users.organization', '=', $orgs);
                $conno->where('users.organization', '=', $orgs);
                $monthscon->where('users.organization', '=', $orgs);
                $monthsconno->where('users.organization', '=', $orgs);
            }

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
        }

        return view('layouts.department.item.data.report2.reporta', compact('depart', 'chartDataCon', 'dateAll', 'chartDataCon2', 'dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'learn', 'con', 'conno'));
    }
    
}
