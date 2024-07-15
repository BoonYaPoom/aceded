<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportBController extends Controller
{
    public function ReportB()
    {
        $sql1 = "SELECT
                    EXTRACT(YEAR FROM users.createdate) + 543 AS year,
                    COUNT(users.username) AS user_count,
                    provinces.name_in_thai AS pro_name
                FROM
                    users
                JOIN
                    provinces ON TO_NUMBER(users.province_id) = TO_NUMBER(provinces.id)
                WHERE users.province_id > 0
                GROUP BY
                    EXTRACT(YEAR FROM users.createdate),
                    provinces.name_in_thai
                ORDER BY
                	pro_name,
                    year";

        $TopTenRegis = collect(DB::select($sql1));


        return view('page.report2.B.reportb',compact('TopTenRegis'));
    }
}
