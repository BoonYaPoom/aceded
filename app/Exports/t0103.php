<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0103 implements
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
        ->join('book', 'logs.idref', '=', 'book.book_id')
        ->where('logs.logid', '=', 10)
            ->select(
                'logs.idref',
                'book.book_name',
                DB::raw('COUNT( logs.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                'logs.idref',
                'book.book_name',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            );
        $datauser = $learner->whereRaw('EXTRACT(YEAR FROM logs.logdate)  + 543 = ?', [$this->year])
            ->distinct()
            ->get();

        $i = 1;
        $datauserAll = $datauser->map(function ($item) use (&$i) {
            
            return [
                'i' => $i + 1,
                'book_name' => $item->book_name,
                'user_count' => $item->user_count,
            ];
        });


        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'เอกสาร e-book Multimedia',
            'จำนวน',
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
