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


            $monthpO = DB::table('users')
                ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $department_id)
                ->where('course_learner.learner_status', '=', 1)
                ->select(
                    DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                    DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                    DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                )
                ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
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
                    DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                    DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                )
                ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
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
                    DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                    DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                )
                ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
                ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                ->get();
            if ($data->user_role == 1 || $data->user_role == 8) {
                $count1;
                $count3;
                $count4;
                $learn = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('users.user_role', 4)
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
                    ->where('users.user_role', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();
                $combinedResult = $learn->merge($con);
                $conno = $learn->map(function ($item) use ($con) {
                    $matchingItem = $con->firstWhere('year', $item->year);
                    return [
                        'year' => $item->year,
                        'user_count' => $item->user_count - ($matchingItem ? $matchingItem->user_count : 0),
                    ];
                });
                $monthscon;
                $monthsconno;
            } elseif ($data->user_role == 7) {
                $count1->where('users.province_id', '=', $provins);
                $count3->where('users.province_id', '=', $provins);
                $count4->where('users.province_id', '=', $provins);

                $learn = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('users.user_role', 4)
                    ->where('users.province_id', '=', $provins)
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
                    ->where('users.user_role', 4)
                    ->where('users.province_id', '=', $provins)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();
                $combinedResult = $learn->merge($con);
                $conno = $learn->map(function ($item) use ($con) {
                    $matchingItem = $con->firstWhere('year', $item->year);
                    return [
                        'year' => $item->year,
                        'user_count' => $item->user_count - ($matchingItem ? $matchingItem->user_count : 0),
                    ];
                });
                $monthscon->where('users.province_id', '=', $provins);
                $monthsconno->where('users.province_id', '=', $provins);
            } elseif ($data->user_role == 6) {
                $count1->where('users.organization', '=', $orgs);
                $count3->where('users.organization', '=', $orgs);
                $count4->where('users.organization', '=', $orgs);
                $learn = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('users.user_role', 4)
                    ->where('users.organization', '=', $orgs)
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
                    ->where('users.user_role', 4)
                    ->where('users.organization', '=', $orgs)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();

                $combinedResult = $learn->merge($con);
                $conno = $learn->map(function ($item) use ($con) {
                    $matchingItem = $con->firstWhere('year', $item->year);

                    return [
                        'year' => $item->year,
                        'user_count' => $item->user_count - ($matchingItem ? $matchingItem->user_count : 0),
                    ];
                });
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
        
        }

        return view('layouts.department.item.data.report2.reporta', compact('depart', 'dateAll','dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'learn', 'con', 'conno'));
    }
}
