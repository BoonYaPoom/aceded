<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0123Controller extends Controller
{
    public function T0123()
    {
        $provin = DB::table('provinces')->get();
        $dateAll = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'month' => $month,
            ];
        }, $dateAll, array_keys($dateAll));

        return view('page.report2.C.table.t0123', compact('provin', 'dateAllWithId'));
    }
}
