<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimUserController extends Controller
{

    public function Certanddepart()
    {
        set_time_limit(0);

        $sql1 = "
        WITH UniDepartments AS (
        SELECT DISTINCT claim_user_id, claim_department_id
        FROM department_claim
        WHERE claim_status < 2
    ),
    ClaimCounts AS (
        SELECT claim_user_id, COUNT(*) AS claim_count
        FROM UniDepartments
        GROUP BY claim_user_id
    )
    SELECT claim_user_id
    FROM ClaimCounts
    WHERE claim_count <= (SELECT COUNT(DEPARTMENT_ID) FROM DEPARTMENT WHERE DEPARTMENT_ID != 10013 AND DEPARTMENT_STATUS = 1) AND claim_user_id > 0
            ";


        $claimuser = collect(DB::select($sql1));

        $cert_file = DB::table('certificate_file')->where('certificate_file_role_status', 2)->get();
        return view(
            'layouts.department.item.data.request.CerAndDepart.index',
            compact('claimuser', 'cert_file')
        );
    }

    public function getClaimData($claimUserId)
    {
        // ดึงข้อมูลจากตาราง 'department_claim' ที่มี claim_user_id เท่ากับ $claimUserId
        $sql = "
    SELECT
        department_claim.claim_status,
        department.name_th AS department_name
    FROM
        department_claim
    LEFT JOIN
        department ON department_claim.claim_department_id = department.department_id
    WHERE
        department_claim.claim_user_id = :claimUserId
        AND department_claim.claim_user_id > 0
        AND department_claim.claim_status < 2
    GROUP BY
        department_claim.claim_status,
        department.name_th
            ";

        $claimData = collect(DB::select($sql, ['claimUserId' => $claimUserId]));

        // ส่งข้อมูลไปยัง view ที่คุณจะใช้แสดงข้อมูลใน Modal
        return response()->json(['claimData' => $claimData]);
    }

    public function updateuserdeyes($claim_user_id)
    {

        $users = DB::table('department_claim')
            ->where('claim_user_id', $claim_user_id)->get();
        DB::table('department_claim')
            ->where('claim_user_id', $claim_user_id)
            ->update(['claim_status' => 2]);

        DB::table('users_department')
            ->where('user_id', $claim_user_id)
            ->delete();

        $maxUserDepartmentId = DB::table('users_department')->max('user_department_id');
        foreach ($users as $departmentId) {
            if ($departmentId->claim_status == 1) {
                $newUserDepartmentId = $maxUserDepartmentId + 1;
                DB::table('users_department')->insert([
                    'user_department_id' => $newUserDepartmentId,
                    'user_id' =>  $claim_user_id,
                    'department_id' => $departmentId->claim_department_id,
                ]);
                $maxUserDepartmentId = $newUserDepartmentId;
            }
        }


        return redirect()->back()->with('message', 'การบันทึกเสร็จสมบูรณ์');
    }
    public function updateuserdeno($claim_user_id)
    {
        DB::table('department_claim')
            ->where('claim_user_id', $claim_user_id)
            ->update(['claim_status' => 2]);
        return redirect()->back()->with('message', 'การบันทึกเสร็จสมบูรณ์');
    }
    public function updateyes($certificate_file_id)
    {
        DB::table('certificate_file')
            ->where('certificate_file_id', $certificate_file_id)
            ->update(['certificate_file_role_status' => 0]);
        return redirect()->back()->with('message', 'การบันทึกเสร็จสมบูรณ์');
    }
    public function updateno($certificate_file_id)
    {
        DB::table('certificate_file')
            ->where('certificate_file_id', $certificate_file_id)
            ->update(['certificate_file_role_status' => 1]);
        return redirect()->back()->with('message', 'การบันทึกเสร็จสมบูรณ์');
    }
}
