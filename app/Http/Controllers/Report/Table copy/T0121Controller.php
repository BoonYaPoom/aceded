<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0121Controller extends Controller
{
    public function T0121()
    {

        $provin = DB::table('provinces')->get();
        $learner = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->where('users_department.department_id' , '=' , 6)
            ->select(
                'provinces.name_in_thai as province_name',
                DB::raw('COUNT( logs.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            )
            ->orderBy(DB::raw('EXTRACT(YEAR FROM logs.logdate)'), 'ASC')
            ->get();

        $dateAll = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));

        return view('page.report2.C.Table.T0121', compact('provin', 'learner', 'dateAllWithId'));
    }
}
