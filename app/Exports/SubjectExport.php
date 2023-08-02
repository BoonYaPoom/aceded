<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\CourseSubject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Framework\Attributes\After;

class SubjectExport implements
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
        return CourseSubject::select('subject_id', 'subject_code', 'subject_th', 'subject_en', 'subject_status')
            ->get()
            ->map(function ($item, $index) {
                $item->subject_id = $index + 1;
                $item->subject_status = $item->subject_status == 1 ? 'on' : 'off';
                return $item;
            });
    }
    public function headings(): array
    {
        return [
           'ลำดับ',
            'รหัส',
            'ชื่อวิชา (ไทย)',
            'ชื่อวิชา (อังกฤษ)',
            'สถานะ',
            'กระทำ',
            // เพิ่มหัวตารางอื่น ๆ ตามต้องการ
        ];
    }
    public function registerEvents(): array{
return [
    AfterSheet::class => function(AfterSheet $event){
        $event->sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true
            ]
            ]);
    }
];
    }
}
