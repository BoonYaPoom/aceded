<?php

namespace App\Http\Controllers\Report\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0103Controller extends Controller
{
    public function T0103()
    {

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $provin = DB::table('provinces')->get();
        $learner = DB::table('users')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->join('book', 'logs.idref', '=', 'book.book_id')
            ->where('logs.logid', '=', 10)
            ->select(
                'logs.idref',
                'book.book_name',
                DB::raw('COUNT( logs.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                'logs.idref',
                'book.book_name',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            )
            ->get();

        return view('page.report2.C.table.t0103', compact('month', 'provin', 'learner'));
    }
}
