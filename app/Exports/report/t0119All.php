<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0119All implements
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
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->where('logs.logid', '=', 1)
            ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            ->select(
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
                DB::raw('COUNT(DISTINCT users.user_id) as user_count'),
                DB::raw('CASE 
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (1, 2, 3) THEN \'1\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (4, 5, 6) THEN \'2\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (7, 8, 9) THEN \'3\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (10, 11, 12) THEN \'4\'
            ELSE \'ไม่ทราบ\'
        END as ta')
            )
            ->groupBy(
                DB::raw('EXTRACT(YEAR FROM logs.logdate)'),
                DB::raw('CASE 
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (1, 2, 3) THEN \'1\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (4, 5, 6) THEN \'2\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (7, 8, 9) THEN \'3\'
            WHEN EXTRACT(MONTH FROM logs.logdate) IN (10, 11, 12) THEN \'4\'
            ELSE \'ไม่ทราบ\'
        END')
            )
            ->whereRaw('EXTRACT(YEAR FROM logs.logdate)  + 543 = ?', [$this->year])
            ->get();

        $dateAll = ['ไตรมาสที่ 1', 'ไตรมาสที่ 2', 'ไตรมาสที่ 3', 'ไตรมาสที่ 4'];

        $dateAllWithId = array_map(function ($month, $index) {
            return [
                'id' => $index + 1,
                'ta' => $month,
            ];
        }, $dateAll, array_keys($dateAll));

        $datauserAll = collect($dateAllWithId)->map(function ($item) use (&$i, $learner) {
            $matchingUser = $learner->where('ta', '=', $item['id'])->first();

            if ($matchingUser) {
                $user_count = $matchingUser->user_count;
            } else {
                $user_count =  0;
            }

            return [
                'i' => $item['id'],
                'ta' => $item['ta'],
                'user_count' => $user_count

            ];
        });


        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'ไตรมาสที่',
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
