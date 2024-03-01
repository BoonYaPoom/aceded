<?php

namespace App\Http\Controllers\ReportDepartment\Table;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0118DPController extends Controller
{
    public function T0118DP($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
        $learner = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->where('users_department.department_id', '=', $department_id)
            ->select(
                'provinces.name_in_thai as province_name',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
                DB::raw('TO_CHAR(logs.logdate, \'MM\') as month_id'),
                DB::raw('COUNT(DISTINCT logs.user_id) as user_count'),
                DB::raw('CASE TO_CHAR(logs.logdate, \'MM\')
                        WHEN \'01\' THEN \'มกราคม\'
                        WHEN \'02\' THEN \'กุมภาพันธ์\'
                        WHEN \'03\' THEN \'มีนาคม\'
                        WHEN \'04\' THEN \'เมษายน\'
                        WHEN \'05\' THEN \'พฤษภาคม\'
                        WHEN \'06\' THEN \'มิถุนายน\'
                        WHEN \'07\' THEN \'กรกฎาคม\'
                        WHEN \'08\' THEN \'สิงหาคม\'
                        WHEN \'09\' THEN \'กันยายน\'
                        WHEN \'10\' THEN \'ตุลาคม\'
                        WHEN \'11\' THEN \'พฤศจิกายน\'
                        WHEN \'12\' THEN \'ธันวาคม\'
                        ELSE \'ไม่ทราบ\'
                    END as month'),
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('TO_CHAR(logs.logdate, \'MM\')')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM logs.logdate)'))
            ->get();

        $dateAll = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));
        return view('layouts.department.item.data.report2.C.table.t0118dp', compact('month', 'provin', 'learner', 'dateAllWithId', 'dateAll', 'depart'));
    }
}
