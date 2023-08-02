<?php

namespace App\Imports;

use App\Models\users;
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
        // if ($row[0] <= 2) {
        $uidplus = users::max('uid'); 
        $username = $request->username ;
        $firstname->firstname  ;
        $lastname->lastname  ;
        $password->password = Hash::make($request->password);
        $citizen_id->citizen_id ;
        $prefix  = '';
        $gender =''  ;
        $email->email  ;
       
        $mobile->mobile  ;

        $role = '';
        $per_id = null;
        $department_id = 12;
        $telephone = null;
        $permission = null;
        $ldap= 0;
        $userstatus = 1;
        $createdate = now();
        $createby ='system';
        $avatar = '';
        $position = '';
        $workplace ='' ;
       
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
        $pos_name = 0  ;
        $sector_id = 0;
        $office_id = 0;

        $user_type ='' ;
        $province_id = '' ;
        $district_id = '' ;
        $subdistrict_id = ''  ;

        return new users([
            'uid' =>  $uidplus + 1, 
            'username' => $row['1'],
            'firstname' => $row['2'],
            'lastname' => $row['3'],
            'password' => $row['4'],
            'citizen_id' => $row['5'],
            'prefix' => $row['6'],
            'gender' => $row['7'],
            'email' => $row['8'],
            'role' => $role,
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
            'mobile' =>  $mobile,
            'socialnetwork' =>  $socialnetwork,
            'experience' =>  $experience,
            'recommened' => $recommened ,
            'templete' => $templete ,
            'nickname' =>  $nickname,
            'introduce' => $introduce ,
            'bgcustom' =>  $bgcustom,
            'pay' =>  $pay,
            'education' => $education ,
            'teach' => $teach ,
            'modern' =>$modern  ,
            'other' => $other ,
            'profiles' =>  $profiles,
            'editflag' => $editflag ,
            'pos_level' =>$pos_level,
            'pos_name' => $pos_name ,
            'sector_id' =>  $sector_id,
            'office_id' => $office_id ,
            'user_type' => $user_type ,
            'province_id' => $province_id ,
            'district_id' => $district_id ,
            'subdistrict_id' =>  $subdistrict_id,
        ]);
    
    }
    }

