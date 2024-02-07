<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0119Controller extends Controller
{
    public function T0119()
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
      
        $learner = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->select(
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
                'provinces.name_in_thai as province_name',
                DB::raw('COUNT(DISTINCT logs.user_id) as user_count'),
                DB::raw('CASE 
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (1, 2, 3) THEN \'1\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (4, 5, 6) THEN \'2\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (7, 8, 9) THEN \'3\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (10, 11, 12) THEN \'4\'
            ELSE \'ไม่ทราบ\'
        END as ta')
            )
            ->groupBy(
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)'),
                DB::raw('CASE 
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (1, 2, 3) THEN \'1\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (4, 5, 6) THEN \'2\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (7, 8, 9) THEN \'3\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (10, 11, 12) THEN \'4\'
            ELSE \'ไม่ทราบ\'
        END')
            )
            ->get();

        $dateAll = ['ไตรมาสที่ 1', 'ไตรมาสที่ 2', 'ไตรมาสที่ 3', 'ไตรมาสที่ 4'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'ta' => $month,
            ];
        }, $dateAll, array_keys($dateAll));
        return view('page.report2.C.table.t0119', compact('month', 'provin', 'learner', 'dateAllWithId', 'dateAll'));
    }
}
