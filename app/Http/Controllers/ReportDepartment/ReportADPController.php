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
                ->whereIn('user_role', [1, 6, 7, 8, 9]);
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
                $monthsconno = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('course_learner.congratulation', '=', 0)
                    ->where('users.user_role', 4)
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
                    ->where('users.user_role', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                        DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                    )
                    ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();

                $register = DB::table('users')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('users.user_role', '=', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)')
                    )
                    ->get();
                $monthsYear = DB::table('users')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('users.user_role', '=', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('TO_CHAR(users.createdate, \'MM\') as month'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(
                        DB::raw('TO_CHAR(users.createdate, \'MM\')')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM users.createdate)'))
                    ->get();
            } elseif ($data->user_role == 7) {
                $users_extender2 = DB::table('users_extender2')
                    ->where('school_province', $provins)
                    ->pluck('extender_id');

                if (in_array($department_id, [1, 2, 3, 5])) {
                    $count1->where('users.province_id', $provins);
                    $count3->where('users.province_id', $provins);
                    $count4->whereIn('users.organization', $users_extender2);
                } elseif (in_array($department_id, [6, 7])) {
                    $count1->where('users.province_id', $provins);
                    $count3->where('users.province_id', $provins);
                    $count4->where('users.province_id', $provins);
                }
                $register = DB::table('users')

                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->whereIn('users.organization', $users_extender2)
                    ->where('users.user_role', 4)
                    ->select(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)')
                    )
                    ->get();
                $learn = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('users.user_role', 4)
                    ->whereIn('users.organization', $users_extender2)
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
                    ->whereIn('users.organization', $users_extender2)
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

                $monthsconno = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('course_learner.congratulation', '=', 0)
                    ->whereIn('users.organization', $users_extender2)
                    ->where('users.user_role', 4)
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
                    ->whereIn('users.organization', $users_extender2)
                    ->where('users.user_role', 4)
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

                $monthsYear = DB::table('users')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->whereIn('users.organization', $users_extender2)
                    ->where('users.user_role', '=', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('TO_CHAR(users.createdate, \'MM\') as month'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(
                        DB::raw('TO_CHAR(users.createdate, \'MM\')')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM users.createdate)'))
                    ->get();
            } elseif ($data->user_role == 6) {
                $count1->where('users.organization', '=', $orgs);
                $count3->where('users.organization', '=', $orgs);
                $count4->where('users.organization', '=', $orgs);
                $register = DB::table('users')

                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('users.organization', '=', $orgs)
                    ->where('users.user_role', 4)
                    ->select(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)')
                    )
                    ->get();
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

                $monthsconno = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('course_learner.congratulation', '=', 0)
                    ->where('users.organization', '=', $orgs)
                    ->where('users.user_role', 4)
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
                    ->where('users.organization', '=', $orgs)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('course_learner.congratulation', '=', 1)

                    ->where('users.user_role', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                        DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                    )
                    ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();
                $monthsYear = DB::table('users')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('users.organization', '=', $orgs)
                    ->where('users.user_role', '=', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('TO_CHAR(users.createdate, \'MM\') as month'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(
                        DB::raw('TO_CHAR(users.createdate, \'MM\')')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM users.createdate)'))
                    ->get();
            } elseif ($data->user_role == 9) {
                $zones = DB::table('user_admin_zone')->where('user_id', $data->user_id)->pluck('province_id')->toArray();
                $count1->whereIn('users.province_id',  $zones);
                $count3->whereIn('users.province_id',  $zones);
                $count4->whereIn('users.province_id',  $zones);
                $register = DB::table('users')

                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->whereIn('users.province_id',  $zones)
                    ->where('users.user_role', 4)
                    ->select(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(

                        DB::raw('EXTRACT(YEAR FROM users.createdate)')
                    )
                    ->get();
                $learn = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('users.user_role', 4)
                    ->whereIn('users.province_id',  $zones)
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
                    ->whereIn('users.province_id',  $zones)
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


                $monthsconno = DB::table('users')
                    ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('course_learner.learner_status', '=', 1)
                    ->where('course_learner.congratulation', '=', 0)
                    ->whereIn('users.province_id',  $zones)
                    ->where('users.user_role', 4)
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
                    ->whereIn('users.province_id',  $zones)
                    ->where('users.user_role', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                        DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\') as month'), // Remove leading zeros
                        DB::raw('COUNT(DISTINCT course_learner.user_id) as user_count')
                    )
                    ->groupBy(DB::raw('LTRIM(TO_CHAR(course_learner.registerdate, \'MM\'), \'0\')'))
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)'))
                    ->get();
                $monthsYear = DB::table('users')
                    ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->whereIn('users.province_id',  $zones)
                    ->where('users.user_role', '=', 4)
                    ->select(
                        DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                        DB::raw('TO_CHAR(users.createdate, \'MM\') as month'),
                        DB::raw('COUNT(DISTINCT users.user_id) as user_count')
                    )
                    ->groupBy(
                        DB::raw('TO_CHAR(users.createdate, \'MM\')')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM users.createdate)'))
                    ->get();
            }

            $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

            $dateAllWithId = array_map(function ($month, $index) {
                return [
                    'id' => $index + 1,
                    'month' => $month,
                ];
            }, $dateAll, array_keys($dateAll));



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
        }

        return view('layouts.department.item.data.report2.reporta', compact('register', 'monthsYear', 'dataMonthWithId', 'depart', 'dateAll', 'dateAllWithId', 'monthscon', 'monthsconno', 'count1', 'count3', 'count4', 'learn', 'con', 'conno'));
    }
}
