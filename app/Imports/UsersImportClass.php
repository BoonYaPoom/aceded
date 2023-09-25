<?php

namespace App\Imports;

use App\Models\users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImportClass implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {


        if ($row[0] >= 2) {
            $uidplus = Users::max('uid');
            $role = 5;
            $prefix = null;
            $gender = null;
            $per_id = null;
            $department_id = 0;
            $permission = null;
            $ldap = 0;
            $userstatus = 1;
            $createdate = now();
            $createby = 2;
            $avatar = '';
            $position = '';
            $workplace = '';
            $telephone = '';
            $citizen_id = '';
            $socialnetwork = '';
            $experience = null;
            $recommened = null;
            $templete = null;
            $nickname = '';
            $introduce = '';
            $bgcustom = '';
            $pay = '';
            $education = '';
            $teach = '';
            $modern = '';
            $other = '';
            $profiles = null;
            $editflag = null;
            $pos_level = 0;
            $pos_name = '';
            $sector_id = 0;
            $office_id = 0;

            $user_type = 0;
            $province_id = 0;
            $district_id = 0;
            $subdistrict_id = 0;
            $recoverpassword = null;
            $employeecode = null;
            $organization = null;

            return new users([
                'user_id' =>  $uidplus + 1,
                'username' => $row[1],
                'password' => Hash::make($row[2]),
                'firstname' => $row[3],
                'lastname' => $row[4],
                'mobile' => $row[5],
                'email' => $row[6],
                
                'prefix' =>  $prefix,
                'gender' => $gender,
                'user_role' => $role,
                'per_id' => $per_id,
                'department_id' => $department_id,
                'permission' => $permission,
                'ldap' => $ldap,
                'userstatus' => $userstatus,
                'createdate' => $createdate,
                'createby' => $createby,
                'avatar' => $avatar,
                'position' =>  $position,
                'workplace' =>  $workplace,
                'telephone' =>  $telephone,
                'citizen_id' =>  $citizen_id,
                'socialnetwork' =>  $socialnetwork,
                'experience' =>  $experience,
                'recommened' => $recommened,
                'templete' => $templete,
                'nickname' =>  $nickname,
                'introduce' => $introduce,
                'bgcustom' =>  $bgcustom,
                'pay' =>  $pay,
                'education' => $education,
                'teach' => $teach,
                'modern' => $modern,
                'other' => $other,
                'profiles' =>  $profiles,
                'editflag' => $editflag,
                'pos_level' => $pos_level,
                'pos_name' => $pos_name,
                'sector_id' =>  $sector_id,
                'office_id' => $office_id,
                'user_type' => $user_type,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'subdistrict_id' =>  $subdistrict_id,
                'recoverpassword' =>  $recoverpassword,
                'employeecode' =>  $employeecode,
                'organization' =>  $organization,
            ]);
        }
    }
}
