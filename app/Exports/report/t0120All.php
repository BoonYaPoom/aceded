<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0120All implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct()
    {

    }
    public function collection()
    {
        $learner = DB::table('users')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->where('logs.logid', '=', 1)
            ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            ->select(
            DB::raw('COUNT(DISTINCT users.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            )
            ->orderBy(DB::raw('EXTRACT(YEAR FROM logs.logdate)'), 'ASC')
            ->get();
        $i = 1;
        $datauserAll = $learner->map(function ($item) use (&$i) {

            return [
                'i' => $i++,
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
            'ปี',
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
