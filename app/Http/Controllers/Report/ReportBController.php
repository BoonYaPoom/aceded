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
                    provinces ON users.province_id = provinces.id
                WHERE users.province_id > 0
                GROUP BY
                    EXTRACT(YEAR FROM users.createdate),
                    provinces.name_in_thai
                ORDER BY
                	pro_name,
                    year";
        $sql2 = "SELECT
            EXTRACT(YEAR FROM certificate_file.certificate_file_date) + 543 AS year,
            COUNT(users.username) AS user_count,
            provinces.name_in_thai AS pro_name
        FROM
            users
        JOIN
            provinces ON users.province_id = provinces.id
        JOIN
            certificate_file ON users.user_id = certificate_file.user_id
        WHERE
            certificate_file.certificate_file_role_status = 1 AND
            certificate_file.certificate_no > 0 AND
            users.province_id > 0
        GROUP BY
            EXTRACT(YEAR FROM certificate_file.certificate_file_date),
            provinces.name_in_thai
        ORDER BY
            pro_name,
            year";


        $admin_zone = " SELECT
                            user_id,
                            LISTAGG(province_id, ', ') WITHIN GROUP (ORDER BY province_id) AS provinces
                        FROM
                            user_admin_zone
                        WHERE user_id > 50   
                        GROUP BY
                            user_id";
        $zone = collect(DB::select($admin_zone));
          
        $TopTenRegis = collect(DB::select($sql1));
        $TopTenCer = collect(DB::select($sql2));





        return view('page.report2.B.reportb', compact('TopTenRegis', 'TopTenCer'));
    }
}
