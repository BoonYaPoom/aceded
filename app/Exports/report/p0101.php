<?php

namespace App\Exports\report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class p0101 implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $department_id;
    protected $year;


    public function __construct($department_id, $year)
    {
        $this->department_id = $department_id;
        $this->year = $year;
    }
    public function collection()
    {
        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
  
            $sql = "SELECT DISTINCT
    users.username,
    users.firstname,
    users.lastname,
    department.name_th AS department_name,
    users_department.department_id,
      CASE
        WHEN users_department.department_id > 5 THEN users.USER_affiliation
        ELSE users_extender2.name
    END AS exten_name,
    course.course_th AS course_th,
    provinces.name_in_thai AS province_name,
    TO_CHAR(course_learner.registerdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS register_date,
    TO_CHAR(course_learner.realcongratulationdate, 'DD Month YYYY', 'NLS_DATE_LANGUAGE=THAI') AS realcongratulationdate,
    EXTRACT(YEAR FROM course_learner.registerdate) + 543 AS year
FROM
    users
JOIN
    course_learner ON TO_NUMBER(users.user_id) = TO_NUMBER(course_learner.user_id)
JOIN
    users_department ON TO_NUMBER(users.user_id) = TO_NUMBER(users_department.user_id)
JOIN
    department ON TO_NUMBER(users_department.department_id) = TO_NUMBER(department.department_id)
JOIN
    provinces ON TO_NUMBER(users.province_id) = TO_NUMBER(provinces.id)
JOIN
    course ON TO_NUMBER(course_learner.course_id) = TO_NUMBER(course.course_id)
    LEFT JOIN
    users_extender2 ON users_department.department_id < 5 AND TO_NUMBER(users.organization) = TO_NUMBER(users_extender2.extender_id)
WHERE
    course_learner.learner_status = 1
    AND users.user_role = 4
    AND course_learner.course_id > 0
    AND users_department.department_id = :department_id
    AND users.province_id = :province_id
    AND EXTRACT(YEAR FROM course_learner.registerdate) + 543 = :year";
            $bindings = [
                'department_id' => $this->department_id,
                'province_id' => $data->province_id,
                'year' => $this->year
            ];

            $rows = collect(DB::select($sql, $bindings));

            $i = 1;
            $datauserAll = $rows->map(function ($item) use (&$i) {
                $fullname =  $item->firstname . ' ' . $item->lastname;
                $exten2 = $item->exten_name;
                $course_th = $item->course_th;
                $register_date = $item->register_date;
                $realcongratulationdate = $item->realcongratulationdate;

                return [
                    'i' => $i++,
                    'fullname' => $fullname,
                    'exten2' => $exten2,
                    'course_th' =>  $course_th,
                    'register_date' => $register_date,
                    'realcongratulationdate' => $realcongratulationdate,
                ];
            });

            return $datauserAll;
        }
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'ชื่อ-นามสกุล',
            'สังกัด',
            'หลักสูตร',
            'วันที่ลงทะเบียนเรียน',
            'วันที่จบหลักสูตร',
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
                $event->sheet->getStyle('A1:J1')->applyFromArray($alignment);

                // ต่อไปเพิ่มคอลัมน์อื่น ๆ ตามต้องการ

                // กำหนดความหนาของตัวหนังสือในทุกคอลัมน์
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
