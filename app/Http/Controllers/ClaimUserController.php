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

        $claimuser = DB::table('department_claim')
            ->select('claim_user_id', 'claim_status') // เลือกเฉพาะคอลัมน์ claim_user_id
            ->where(function ($query) {
                $query->where('claim_status', 1);
            })
            ->where('claim_status', '<', 2)
            ->distinct()
            ->get();
        $claimData = ' ';
        foreach ($claimuser as $user) {

            if ($claimData) {
                $claimData = DB::table('department_claim')
                    ->where('claim_user_id', $user->claim_user_id)
                    ->get();
            } elseif ($claimData === null) {

                $claimData = null;
            }
        }
        $cert_file = DB::table('certificate_file')->where('certificate_file_role_status', 2)->get();
        return view(
            'layouts.department.item.data.request.CerAndDepart.index',
            compact('claimuser', 'cert_file', 'claimData')
        );
    }

    public function getClaimData($claimUserId)
    {
        // ดึงข้อมูลจากตาราง 'department_claim' ที่มี claim_user_id เท่ากับ $claimUserId

        $claimData = DB::table('department_claim')->where('claim_user_id', $claimUserId)
            ->where('department_claim.claim_user_id', '>', 0)
            ->where('department_claim.claim_status', '<', 2)
            ->leftJoin('department', 'department_claim.claim_department_id', '=', 'department.department_id')
            ->select(
                'department_claim.*',
                'department.name_th as department_name'
            )
            ->get();

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
