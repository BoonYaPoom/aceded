<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\UserDepartment;
use App\Models\Users;
use App\Models\UserSchool;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserAlldepartClass implements ToModel
{
    /**
    * @param Collection $collection
    */
    private $department_id;
    private $school_id;
    public function __construct($department_id)
    {
        $this->department_id = $department_id;

    }

    public function model(array $row)
    {

        // ใช้ $this->subjectId เพื่อเข้าถึงค่า subject_id ที่ถูกส่งเข้ามา
        $department_id = $this->department_id;


        if ($row[0] >= 2) {
            return DB::transaction(function () use ($row, $department_id) {
                $uidUserSchool = UserSchool::max('user_school_id');
                $uidplus = Users::max('uid');
                $role = 5;
                $prefix = null;

                $per_id = null;

                $permission = null;
                $ldap = 0;
                $userstatus = 1;
                $createdate = now();
                $createby = 2;
                $avatar = '';
                $position = '';
                $workplace = '';
                $telephone = '';

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

                $newUsers =  new users([
                    'user_id' =>  $uidplus + 1,
                    'username' => $row[1],
                    'password' => Hash::make($row[2]),
                    'firstname' => $row[3],
                    'lastname' => $row[4],
                    'mobile' => $row[5],
                    'email' => $row[6],
                    'citizen_id' =>  $row[7],
                    'gender' => $row[8],
                    'prefix' =>  $prefix,

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
                $newUserSchool =  new UserSchool([

                    'user_school_id' =>  $uidUserSchool + 1,
                    'school_id' =>   $row[9],
                    'user_id' =>   $uidplus + 1,
                    'department_id' => $department_id,

                ]);
                $newUserDepartment =  new UserDepartment([

                    'user_department_id' =>  $uidUserSchool + 1,
                    'user_id' =>   $uidplus + 1,
                    'department_id' => $department_id,

                ]);
                return [
                    'user' => $newUsers,
                    'userSchool' => $newUserSchool,
                    'UserDepartment' => $newUserDepartment,
                ];
            });
        }
    }
}
