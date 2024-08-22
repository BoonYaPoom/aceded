<?php


namespace App\Exports;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\Provinces;
use App\Models\UserDepartment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $sql = "WITH DepartmentCheck AS (
    SELECT 
        USER_ID,
        CASE 
            WHEN COUNT(DEPARTMENT_ID) <= 5 THEN 1 
            ELSE 0 
        END AS DEPARTMENT_STAY
    FROM 
        USERS_DEPARTMENT
    GROUP BY 
        USER_ID
)
SELECT 
    dc.DEPARTMENT_STAY,
 users.user_id,
 users.username AS USERNAME,
 users.firstname AS FIRSTNAME,
 users.WORKPLACE AS WORKPLACE,
 users.lastname AS LASTNAME,
 TO_CHAR(users.createdate, 'YYYY-MM-DD') AS CREATE_DATE,
 TO_CHAR(users.createdate, 'hh24:mi:ss') AS CREATE_TIME,
 users.province_id,
 provinces.name_in_thai AS PROVINCES_NAME,
 districts.name_in_thai AS DISTRICTS_NAME,
 subdistricts.name_in_thai AS SUBDISTRICTS_NAME,
 users.mobile AS MOBILE,
 users.organization,
 users.user_affiliation AS USER_AFFILIATION,
 users.userstatus AS USERSTATUS,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   users_extender2.name
  FROM
   users_extender2
  WHERE
   users_extender2.extender_id = users.organization)
  ELSE '-'
 END AS newNameExten,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN CASE
   WHEN users.province_id > 0 THEN (
   SELECT
    NAME_IN_THAI
   FROM
    PROVINCES
   WHERE
    id = users.province_id)
   ELSE (
   SELECT
    NVL(provinces.name_in_thai, '-')
   FROM
    users_extender2
   LEFT JOIN provinces ON
    users_extender2.school_province = provinces.id
   WHERE
    users_extender2.extender_id = users.organization)
  END
  ELSE (
  SELECT
   NAME_IN_THAI
  FROM
   PROVINCES
  WHERE
   id = users.province_id)
 END AS NEWUSERPROVINCE,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   provinces.name_in_thai
  FROM
   users_extender2
  LEFT JOIN provinces ON
   users_extender2.school_province = provinces.id
  WHERE
   users_extender2.extender_id = users.organization)
  ELSE '-'
 END AS NEWPROVINCEEXTEN,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   districts.name_in_thai
  FROM
   users_extender2
  LEFT JOIN districts ON
   users_extender2.school_district = districts.id
  WHERE
   users_extender2.extender_id = users.organization)
  ELSE '-'
 END AS NEWDISTRICTSEXTEN,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   subdistricts.name_in_thai
  FROM
   users_extender2
  LEFT JOIN subdistricts ON
   users_extender2.school_subdistrict = subdistricts.id
  WHERE
   users_extender2.extender_id = users.organization)
  ELSE '-'
 END AS NEWSUBDISTRICTSEXTEN,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   users_extender2.item_parent_id
  FROM
   users_extender2
  WHERE
   users_extender2.extender_id = users.organization)
  ELSE 0
 END AS NEWPARENT,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN (
  SELECT
   users_extender2.name
  FROM
   users_extender2
  WHERE
   users_extender2.extender_id = (
   SELECT
    users_extender2.item_parent_id
   FROM
    users_extender2
   WHERE
    users_extender2.extender_id = users.organization))
  ELSE '-'
 END AS NEWPARENTNAME,
 CASE
  WHEN dc.DEPARTMENT_STAY = 1 THEN '-'
  ELSE CASE
   WHEN INSTR(users.user_affiliation, 'ระดับ') > 0 THEN (
   SELECT
    users_extender2.name
   FROM
    users_extender2
   WHERE
    users_extender2.extender_id = users.organization)
   ELSE users.user_affiliation
  END
 END AS EXTENNONAME
FROM
 users
JOIN DepartmentCheck dc ON dc.USER_ID = users.user_id
LEFT JOIN provinces ON
 provinces.id = users.province_id
LEFT JOIN districts ON
 districts.id = users.district_id
LEFT JOIN subdistricts ON
 subdistricts.id = users.subdistrict_id
WHERE
 users.user_role = 4
 AND users.province_id != 0";

        $rows = collect(DB::select($sql));

        $i = 1;
        $datauser = $rows->map(function ($item) use (&$i) {
            $full_name = $item->firstname . ' ' . $item->lastname;
       
            $newexten1 = $item->newnameexten;
            $newexten2 = $item->newparentname;
            $newexten3 =  $item->newuserprovinceexten ??  $item->provinces_name ?? "-";
            $newexten4 =  $item->newdistrictsexten ?? $item->districts_name ?? "-";
            $newexten5 =  $item->newsubdistrictsexten ?? $item->subdistricts_name ?? "-";
            if ($item->newnameexten == null) {
                $newexten1 = "-";
                $newexten2 = "-";
                $newexten3 = "-";
                $newexten4 =  "-";
                $newexten5 =  "-";
            }
            if ($item->department_stay > 5) {
      
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
