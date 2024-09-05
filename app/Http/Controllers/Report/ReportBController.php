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
                    provinces.name_in_thai AS pro_name,
                    provinces.id as pro_id
                FROM
                    users
                JOIN
                    provinces ON users.province_id = provinces.id
                WHERE users.province_id > 0
                GROUP BY
                    EXTRACT(YEAR FROM users.createdate),
                    provinces.id,
                    provinces.name_in_thai
                ORDER BY
                	pro_name,
                    year";
        $sql2 = "SELECT
            EXTRACT(YEAR FROM certificate_file.certificate_file_date) + 543 AS year,
            COUNT(users.username) AS user_count,
            provinces.name_in_thai AS pro_name,
            provinces.id as pro_id
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
            provinces.id,
            provinces.name_in_thai
        ORDER BY
            pro_name,
            year";

        $admin_zone = " SELECT
                            user_admin_zone.user_id,
                            JSON_ARRAYAGG(user_admin_zone.province_id ORDER BY user_admin_zone.province_id) AS provinces,
                            users.lastname
                        FROM
                            user_admin_zone
                        JOIN
                             users ON user_admin_zone.user_id = users.user_id
                        WHERE user_admin_zone.user_id > 50   
                        GROUP BY
                            user_admin_zone.user_id,
                            users.lastname";
        $zone = collect(DB::select($admin_zone));
        $regisResults = [];
        $cerReuslts = [];
        $regisDepResults = [];
        $cerDepReuslts = [];
        $regisProvincResults = [];
        $cerProvincReuslts = [];
        $zone->each(function ($item) use (&$regisResults, &$cerReuslts, &$regisDepResults, &$cerDepReuslts, &$regisProvincResults, &$cerProvincReuslts) {

            $provincesList = implode(',', json_decode($item->provinces, true));
            $sql4 = "SELECT
             EXTRACT(YEAR FROM users.createdate) + 543 AS year,
             COUNT(users.username) AS total_user_count
         FROM
             users
         WHERE users.province_id > 0 AND users.province_id IN ($provincesList)
         GROUP BY
             EXTRACT(YEAR FROM users.createdate)
         ORDER BY
             year";
            $resultssql4 = DB::select($sql4);
            $regisResults[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql4
            ];

            $sql5 = "SELECT
            EXTRACT(YEAR FROM certificate_file.certificate_file_date) + 543 AS year,
            COUNT(users.username) AS total_user_count
        FROM
            users
        JOIN
            certificate_file ON users.user_id = certificate_file.user_id
        WHERE
            certificate_file.certificate_file_role_status = 1
            AND certificate_file.certificate_no > 0
            AND users.province_id > 0
            AND users.province_id IN ($provincesList)
        GROUP BY
            EXTRACT(YEAR FROM certificate_file.certificate_file_date)
        ORDER BY
            year";

            $resultssql5 = DB::select($sql5);
            $cerReuslts[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql5
            ];

            $sql6 = "SELECT
            EXTRACT(YEAR FROM users.createdate) + 543 AS year,
            COUNT(users.username) AS total_user_count,
            users_department.department_id,
            department.name_th
        FROM
            users
        JOIN
            users_department ON users.user_id = users_department.user_id
        JOIN
            department ON users_department.department_id = department.department_id
        WHERE
            users.province_id > 0
            AND users.province_id IN ($provincesList)
        GROUP BY
            EXTRACT(YEAR FROM users.createdate),
            users_department.department_id,
            department.name_th
        ORDER BY
            year, 
            users_department.department_id";
            $resultssql6 = DB::select($sql6);
            $regisDepResults[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql6
            ];

            $sql7 = "SELECT
            EXTRACT(YEAR FROM certificate_file.certificate_file_date) + 543 AS year,
            COUNT(users.username) AS total_user_count,
            users_department.department_id,
            department.name_th
        FROM
            users
        JOIN
            certificate_file ON users.user_id = certificate_file.user_id
        JOIN
            users_department ON users.user_id = users_department.user_id
        JOIN
            department ON users_department.department_id = department.department_id
        WHERE
            certificate_file.certificate_file_role_status = 1
            AND certificate_file.certificate_no > 0
            AND users.province_id > 0
            AND users.province_id IN ($provincesList)
        GROUP BY
            EXTRACT(YEAR FROM certificate_file.certificate_file_date),
            users_department.department_id,
            department.name_th
        ORDER BY
            year,
            users_department.department_id";

            $resultssql7 = DB::select($sql7);

            $cerDepReuslts[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql7
            ];
            "SELECT
                    EXTRACT(YEAR FROM users.createdate) + 543 AS year,
                    COUNT(users.username) AS user_count,
                    provinces.name_in_thai AS pro_name,
                    provinces.id as pro_id
                FROM
                    users
                JOIN
                    provinces ON users.province_id = provinces.id
                WHERE users.province_id > 0
                GROUP BY
                    EXTRACT(YEAR FROM users.createdate),
                    provinces.id,
                    provinces.name_in_thai
                ORDER BY
                	pro_name,
                    year";

            $sql8 = "SELECT
                    EXTRACT(YEAR FROM users.createdate) + 543 AS year,
                    COUNT(users.username) AS total_user_count,
                    provinces.name_in_thai AS pro_name,
                    provinces.id as pro_id
                FROM
                    users
                JOIN
                provinces ON users.province_id = provinces.id
                WHERE
                    users.province_id > 0
                    AND users.province_id IN ($provincesList)
                GROUP BY
                    EXTRACT(YEAR FROM users.createdate),
                    provinces.id,
                    provinces.name_in_thai
                ORDER BY
                    pro_name,
                    year";

            $resultssql8 = DB::select($sql8);
            $regisProvincResults[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql8
            ];

            $sql9 = "SELECT
            EXTRACT(YEAR FROM certificate_file.certificate_file_date) + 543 AS year,
            COUNT(users.username) AS total_user_count,
            provinces.name_in_thai AS pro_name,
            provinces.id as pro_id
        FROM
            users
        JOIN
            certificate_file ON users.user_id = certificate_file.user_id
        JOIN
            provinces ON users.province_id = provinces.id
        WHERE
            certificate_file.certificate_file_role_status = 1
            AND certificate_file.certificate_no > 0
            AND users.province_id > 0
            AND users.province_id IN ($provincesList)
        GROUP BY
            EXTRACT(YEAR FROM certificate_file.certificate_file_date),
            provinces.id,
            provinces.name_in_thai
        ORDER BY
            pro_name,
            year";

            $resultssql9 = DB::select($sql9);
            $cerProvincReuslts[$item->user_id] = [
                'lastname' => $item->lastname,
                'data' => $resultssql9
            ];
        });

        $TopTenRegis = collect(DB::select($sql1));
        $TopTenCer = collect(DB::select($sql2));


        return view('page.report2.B.reportb', compact('TopTenRegis', 'TopTenCer', 'regisResults', 'cerReuslts', 'regisDepResults', 'cerDepReuslts', 'cerProvincReuslts', 'regisProvincResults'));
    }
}
