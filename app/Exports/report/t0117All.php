<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0117All implements
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
        $learner
            = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
            ->whereIn('department.department_id', [1, 2, 3, 5, 6, 7])
            ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            ->select(
                'department.department_id',
                'course.course_th as course_th',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT course_learner.user_id)  as user_count')
            )
            ->groupBy(
                'department.department_id',
                'course.course_th',
                'department.name_th',
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate) + 543')
            )
            ->orderBy('department.department_id', 'ASC');

        $datauser = $learner->whereRaw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543 = ?', [$this->year])
            ->distinct()
            ->get();

        $i = 1;
        $datauserAll = $datauser->map(function ($item) use (&$i) {

            $depas = '';
            if ($item->department_id == 1 || $item->department_id == 2) {
                $depas = 'อายุไม่เกิน 11 ปี';
            } elseif ($item->department_id == 3) {
                $depas = 'อายุ 12 - 17 ปี';
            } elseif ($item->department_id == 5) {
                $depas = 'อายุ 18 - 25 ปี';
            } elseif ($item->department_id == 6 || $item->department_id == 7) {
                $depas = 'อายุเกิน 25 ปีขึ้นไป';
            }


            return [
                'i' => $i++,
                'course_th' => $item->course_th,
                'depas' => $depas,
                'user_count' => $item->user_count,
            ];
        });


        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'ชื่อหลักสูตร',
            'ช่วงอายุ',
            'จำนวน (คน)',
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
