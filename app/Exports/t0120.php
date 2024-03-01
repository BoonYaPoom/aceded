<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0120 implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $department_id;
    protected $provin_name;



    public function __construct($department_id, $provin_name)
    {
        $this->department_id = $department_id;
        $this->provin_name = $provin_name;

    }
    public function collection()
    {
        $learner = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->where('provinces.name_in_thai', '=', $this->provin_name)
            ->where('users_department.department_id', '=', $this->department_id)
            ->select(
                'department.department_id',
                'provinces.name_in_thai as province_name',
                DB::raw('COUNT( logs.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                'department.department_id',
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            )
            ->orderBy(DB::raw('EXTRACT(YEAR FROM logs.logdate)'), 'ASC')
            ->get();

        $datauserAll = $learner->map(function ($item) use (&$i) {

            return [
                'i' => $i + 1,
                'course_th' => $item->year,
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
