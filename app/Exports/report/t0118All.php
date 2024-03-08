<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0118All implements
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
                DB::raw('CASE TO_CHAR(logs.logdate, \'MM\')
                        WHEN \'01\' THEN \'มกราคม\'
                        WHEN \'02\' THEN \'กุมภาพันธ์\'
                        WHEN \'03\' THEN \'มีนาคม\'
                        WHEN \'04\' THEN \'เมษายน\'
                        WHEN \'05\' THEN \'พฤษภาคม\'
                        WHEN \'06\' THEN \'มิถุนายน\'
                        WHEN \'07\' THEN \'กรกฎาคม\'
                        WHEN \'08\' THEN \'สิงหาคม\'
                        WHEN \'09\' THEN \'กันยายน\'
                        WHEN \'10\' THEN \'ตุลาคม\'
                        WHEN \'11\' THEN \'พฤศจิกายน\'
                        WHEN \'12\' THEN \'ธันวาคม\'
                        ELSE \'ไม่ทราบ\'
                    END as month'),
            )
            ->groupBy(
                
                DB::raw('TO_CHAR(logs.logdate, \'MM\')'),
                DB::raw('CASE TO_CHAR(logs.logdate, \'MM\')
                        WHEN \'01\' THEN \'มกราคม\'
                        WHEN \'02\' THEN \'กุมภาพันธ์\'
                        WHEN \'03\' THEN \'มีนาคม\'
                        WHEN \'04\' THEN \'เมษายน\'
                        WHEN \'05\' THEN \'พฤษภาคม\'
                        WHEN \'06\' THEN \'มิถุนายน\'
                        WHEN \'07\' THEN \'กรกฎาคม\'
                        WHEN \'08\' THEN \'สิงหาคม\'
                        WHEN \'09\' THEN \'กันยายน\'
                        WHEN \'10\' THEN \'ตุลาคม\'
                        WHEN \'11\' THEN \'พฤศจิกายน\'
                        WHEN \'12\' THEN \'ธันวาคม\'
                        ELSE \'ไม่ทราบ\'
                    END'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)'),
            )

            ->whereRaw('EXTRACT(YEAR FROM logs.logdate)  + 543 = ?', [$this->year])
            ->get();


        $dateAll = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        $dateAllWithId = [];
        foreach ($dateAll as $index => $month) {
            $dateAllWithId[] = [
                'id' => $index + 1,
                'month' => $month,
            ];
        }

        $datauserAll = collect($dateAllWithId)->map(function ($item) use (&$i, $learner) {
            $matchingUser = $learner->where('month', '=', $item['month'])->first();

            if ($matchingUser) {
                $user_count = $matchingUser->user_count;
            } else {
                $user_count =  0;
            }

            return [
                'i' => $item['id'],
                'month' => $item['month'],
                'user_count' => $user_count

            ];
        });


        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'เดือน',
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
