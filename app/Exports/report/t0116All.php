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
        $learner = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
            ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            ->select(
                'users.username',
                'users.firstname',
                'users.lastname',
            'department.department_id as department_id_ace',
                'department.name_th as department_name',
                'users_department.department_id',
                'users_extender2.name as exten_name',
                'course.course_th as course_th',
                'provinces.name_in_thai as province_name',
                'course_learner.congratulation as congratulation',
                DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as register_date"),
                DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as realcongratulationdate"),
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
            )->orderBy('department_id_ace');
        $datauser = $learner->whereRaw('EXTRACT(YEAR FROM course_learner.registerdate) + 543 = ?', [$this->year])
            ->distinct()
            ->get();


        $i = 1;
        $datauserAll = $datauser->map(function ($item) use (&$i) {
            $fullname =  $item->firstname . ' ' . $item->lastname;
            $exten2 = $item->exten_name;
            $course_th = $item->course_th;
            $congratulation = $item->congratulation;
            $department_name = $item->department_name;
            if ($congratulation == 0) {
                $cons = 'N';
            } elseif ($congratulation == 1) {
                $cons = 'N/A';
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
