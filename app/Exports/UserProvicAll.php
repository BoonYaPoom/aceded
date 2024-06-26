<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Str;


class UserProvicAll implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $provicValue;

    public function __construct($provicValue)
    {

        $this->provicValue = $provicValue;
    }
    public function collection()
    {
        if (Session::has('loginId')) {
            $data =
                DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $provicValue = $data->province_id;
            // $users = DB::table('users')
            //     ->where('users.province_id', $provicValue)
            //     ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            //     ->select(
            //         'users.user_id',
            //         'users.username',
            //         'users.firstname',
            //         'users.lastname',
            //         'users.createdate',
            //         'users.province_id',
            //         'users.mobile',
            //         'users.organization',
            //         'users.user_affiliation',
            //         'users.userstatus'
            //     )->groupBy(
            //         'users.user_id',
            //         'users.username',
            //         'users.firstname',
            //         'users.lastname',
            //         'users.createdate',
            //         'users.province_id',
            //         'users.mobile',
            //         'users.organization',
            //         'users.user_affiliation',
            //         'users.userstatus'
            //     )->get();



            $sql = "SELECT users_department.department_id, users_department.user_id, users.username AS USERNAME, users.firstname AS FIRSTNAME, users.WORKPLACE AS WORKPLACE, users.lastname AS LASTNAME, TO_CHAR(users.createdate,'YYYY-MM-DD') AS CREATE_DATE, TO_CHAR(users.createdate,'hh24:mi:ss') AS CREATE_TIME, users.province_id, provinces.name_in_thai AS PROVINCES_NAME, districts.name_in_thai AS DISTRICTS_NAME, subdistricts.name_in_thai AS SUBDISTRICTS_NAME, users.mobile AS MOBILE, users.organization, users.user_affiliation AS USER_AFFILIATION, users.userstatus AS USERSTATUS, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS newNameExten, CASE WHEN users_department.department_id <= 5 THEN CASE WHEN users.province_id > 0 THEN (SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) ELSE (SELECT NVL(provinces.name_in_thai, '-') FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) END ELSE (SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) END AS NEWUSERPROVINCE, CASE WHEN users_department.department_id <= 5 THEN (SELECT provinces.name_in_thai FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWPROVINCEEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT districts.name_in_thai FROM users_extender2 LEFT JOIN districts ON users_extender2.school_district = districts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT subdistricts.name_in_thai FROM users_extender2 LEFT JOIN subdistricts ON users_extender2.school_subdistrict = subdistricts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWSUBDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE 0 END AS NEWPARENT, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization)) ELSE '-' END AS NEWPARENTNAME, CASE WHEN users_department.department_id <= 5 THEN '-' ELSE CASE WHEN INSTR(users.user_affiliation, 'ระดับ') > 0 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE users.user_affiliation END END AS EXTENNONAME FROM users JOIN users_department ON users.user_id = users_department.user_id LEFT JOIN provinces ON provinces.id = users.province_id LEFT JOIN districts ON districts.id = users.district_id LEFT JOIN subdistricts ON subdistricts.id = users.subdistrict_id WHERE users.user_role = 4 AND  users.province_id = :province_id GROUP BY users_department.department_id, users_department.user_id, users.username, users.firstname, users.WORKPLACE, users.lastname, users.createdate, users.province_id, provinces.name_in_thai, districts.name_in_thai, subdistricts.name_in_thai, users.mobile, users.organization, users.user_affiliation, users.userstatus";

            $rows = collect(DB::select($sql, ['province_id' => $provicValue]));
            $i = 1;
            $datauser = $rows->map(function ($item) use (&$i) {
                $full_name = $item->firstname . ' ' . $item->lastname;
                $from = 'จังหวัด ' . $item->provinces_name . ' / อำเภอ ' . $item->districts_name . ' / ตำบล ' . $item->subdistricts_name;
                $fromExten = $item->newnameexten .  $item->newparentname . ' / ตำบล ' . $item->subdistricts_name . ' / อำเภอ ' . $item->districts_name  . ' / จังหวัด ' . $item->provinces_name;

                $newexten1 = $item->newnameexten;
                $newexten2 = $item->newparentname;
                $newexten3 =  $item->newuserprovinceexten ??  $item->provinces_name;
                $newexten4 =  $item->newdistrictsexten ?? $item->districts_name;
                $newexten5 =  $item->newsubdistrictsexten ?? $item->subdistricts_name;
                if ($item->newnameexten == null) {
                    $newexten1 = "-";
                    $newexten2 = "-";
                    $newexten3 = "-";
                    $newexten4 =  "-";
                    $newexten5 =  "-";
                }
                if ($item->department_id > 5) {
                    $fromExten = $item->extennoname;
                    $newexten1 = $item->extennoname;
                    $newexten2 = "-";
                    $newexten3 = "-";
                    $newexten4 =  "-";
                    $newexten5 =  "-";
                }

                return [
                    'i' => $i++,
                    'username' => $item->username,
                    'fullname' => $full_name,
                    'mobile' => $item->mobile,
                    'workplace' => $item->workplace,
                    'provi' =>  $item->provinces_name,
                    'dis' =>  $item->districts_name,
                    'subdis' =>  $item->subdistricts_name,
                    'user_affiliation' => $item->user_affiliation,
                    'extender2' =>  $newexten1,
                    'subexten' => $newexten2,
                    '2provi' =>  $newexten3,
                    '2dis' =>   $newexten4,
                    '2subdis' => $newexten5,
                    'createdate' => $item->create_date,
                    'formattedTime' => $item->create_time,
                    'status' =>  $item->userstatus = 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน',
                ];
            });
            set_time_limit(0);
            ini_set('memory_limit', '-1');
            return $datauser;

        } else {
            $users = collect();
        }
    }


    public function headings(): array
    {
        return [
            'ลำดับ',
            'รหัสผู้ใช้',
            'ชื่อ-นามสกุล',
            'เบอร์',
            'ที่อยู่ปัจจุบัน/ที่อยู่หน่วยงาน',
            'มาจาก',
            'อำเภอ',
            'ตำบล',
            'ระดับ',
            'หน่วยงาน',
            'สังกัด',
            'จังหวัด',
            'อำเภอ',
            'ตำบล',
            'วันที่สร้าง',
            'เวลา',
            'สถานะ',

            // เพิ่มหัวตารางอื่น ๆ ตามต้องการ
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $alignment = [
                    'alignment' => [
                        'horizontal' => 'left', // กำหนดให้ชิดซ้าย
                    ],
                ];

                // กำหนดการจัดวางเฉพาะคอลัมน์ที่คุณต้องการ
                $event->sheet->getStyle('A1:Q1')->applyFromArray($alignment);

                // ต่อไปเพิ่มคอลัมน์อื่น ๆ ตามต้องการ

                // กำหนดความหนาของตัวหนังสือในทุกคอลัมน์
                $event->sheet->getStyle('A1:Q1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
