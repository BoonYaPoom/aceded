<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0116All implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }
    public function collection()
    {
        $sql = "SELECT DISTINCT
                            users.username,
                            users.firstname,
                            users.lastname,
                            department.name_th AS department_name,
                            users_department.department_id,
                            course_learner.congratulation as congratulation,
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

                            AND EXTRACT(YEAR FROM course_learner.registerdate) + 543 = :year
                        ";
        $bindings = ['year' => $this->year];

        $rows = collect(DB::select($sql, $bindings));


        $i = 1;
        $datauserAll = $rows->map(function ($item) use (&$i) {
            $fullname =  $item->firstname . ' ' . $item->lastname;
            $exten2 = $item->exten_name;
            $course_th = $item->course_th;
            $congratulation = $item->congratulation;
            $department_name = $item->department_name;
            if ($congratulation == 0) {
                $cons = 'N/A';
            } elseif ($congratulation == 1) {
                $cons = 'P';
            }

            return [
                'i' => $i++,
                'fullname' => $fullname,
                'exten2' => $exten2,
                'department_name' =>  $department_name,
                'course_th' =>  $course_th,
                'cons' =>  $cons,
            ];
        });


        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'ชื่อ-นามสกุล',
            'สังกัด',
            'ระดับ',
            'หลักสูตร',
            'N/A = กำลังเรียน P = เรียนจบ',

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
