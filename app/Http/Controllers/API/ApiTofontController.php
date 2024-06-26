<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTofontController extends Controller
{
    function provinces(Request $request)
    {

        $provinces = DB::table('provinces');
        $data = [];
        $lang = $request->input('lang');
        if ($provinces->count() >= 1) {
            foreach ($provinces->get() as $row) {
                $provinces_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'provinces_id' => $row->id,
                    'provinces_name' => $provinces_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);
    }
    function districts(Request $request)
    {
        $lang = $request->input('lang');
        $province = $request->input('province');
        $districts = DB::table('districts')->where('province_id', '=', $province);
        $data = [];
        if ($districts->count() >= 1) {
            foreach ($districts->get() as $row) {
                $districts_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'districts_id' => $row->id,
                    'districts_name' => $districts_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);
    }


    function subdistricts(Request $request)
    {

        $lang = $request->input('lang');
        $district = $request->input('district');
        $subdistricts = DB::table('subdistricts')->where('district_id', '=', $district);
        $data = [];

        if ($subdistricts->count() >= 1) {
            foreach ($subdistricts->get() as $row) {
                $subdistricts_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'subdistricts_id' => $row->id,
                    'subdistricts_name' => $subdistricts_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);
    }
    public function usersapina(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 100);
        $searchValue = $request->query('searchValue', '');
        $orderColumn = $request->query('orderColumn', 'user_id');
        $orderDir = $request->query('orderDir', 'asc');
        $offset = ($page - 1) * $limit;

        $sql = "SELECT ROWNUM AS row_number, users_department.department_id, users_department.user_id, users.username AS USERNAME, users.firstname AS FIRSTNAME ,users.WORKPLACE  AS WORKPLACE , users.lastname AS LASTNAME, TO_CHAR(users.createdate,'YYYY-MM-DD') AS CREATE_DATE,TO_CHAR(users.createdate,'hh24:mi:ss') AS CREATE_TIME , users.province_id, provinces.name_in_thai AS PROVINCES_NAME, districts.name_in_thai AS DISTRICTS_NAME, subdistricts.name_in_thai AS SUBDISTRICTS_NAME, users.mobile AS MOBILE, users.organization, users.user_affiliation AS USER_AFFILIATION, users.userstatus AS USERSTATUS, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2  WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS newNameExten, CASE WHEN users_department.department_id <= 5 THEN CASE WHEN users.province_id > 0 THEN(SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) ELSE (SELECT NVL(provinces.name_in_thai, '-') FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) END ELSE (SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) END AS NEWUSERPROVINCE, CASE WHEN users_department.department_id <= 5 THEN (SELECT provinces.name_in_thai FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWPROVINCEEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT districts.name_in_thai FROM users_extender2 LEFT JOIN districts ON users_extender2.school_district = districts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT subdistricts.name_in_thai FROM users_extender2 LEFT JOIN subdistricts ON users_extender2.school_subdistrict = subdistricts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWSUBDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE 0 END AS NEWPARENT, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization)) ELSE '-' END AS NEWPARENTNAME, CASE WHEN users_department.department_id <= 5 THEN '-' ELSE CASE WHEN INSTR(users.user_affiliation, 'ระดับ') > 0 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE users.user_affiliation END END AS EXTENNONAME 
FROM users 
JOIN users_department ON users.user_id = users_department.user_id 
LEFT JOIN provinces ON provinces.id = users.province_id 
LEFT JOIN districts ON districts.id = users.district_id 
LEFT JOIN subdistricts ON subdistricts.id = users.subdistrict_id 
WHERE users.user_role = 4
AND (users.username LIKE ? OR users.firstname LIKE ? OR users.lastname LIKE ?)
  GROUP BY ROWNUM, users_department.department_id, users_department.user_id, users.username, users.firstname ,users.WORKPLACE, users.lastname, users.createdate, users.province_id, provinces.name_in_thai, districts.name_in_thai, subdistricts.name_in_thai, users.mobile, users.organization, users.user_affiliation, users.userstatus
ORDER BY $orderColumn $orderDir
OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

        $rows = collect(DB::select($sql, ["%$searchValue%", "%$searchValue%", "%$searchValue%", $offset, $limit]));

        // Total number of records
        $totalRows = DB::table('users')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->where('users.user_role', 4)
            ->count();

        return response()->json([
            'result' => 1,
            'recordsTotal' => $totalRows,
            'recordsFiltered' => $totalRows,
            'data' => $rows,
        ], 200);
    }
}
