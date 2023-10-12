<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ReportExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */


    use Exportable;

    public function collection()
    {
        // จัดเก็บข้อมูลรายงานที่คุณต้องการสร้างไฟล์ Excel
        // สร้างเป็นคอลเล็กชันและส่งคืนข้อมูลที่คุณต้องการ
        return collect([
            [1, 'รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร', ''],
            [2, 'รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด', ''],
            [3, 'รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน', ''],
            [4, 'รายงานการ Login ของผู้เรียน', ''],
            [5, 'ข้อมูล Log File ในรูปแบบรายงานทางสถิติ', ''],
        ]);
    }
    public function headings(): array
    {
        return [
            ['รายงานเชิงตาราง ปี 2566'],
            ['ลำดับ', 'ชื่อรายงาน', 'รายงาน'],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();

                // กำหนดขอบเซลล์
                $cellRange = 'A1:F1';

                $worksheet->mergeCells($cellRange);

                // กำหนดรูปแบบของเซลล์ใน Excel
                $style = [
                    'font' => ['size' => 16],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,

                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                        'inside' => [ // ขอบสัมพันธ์
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ];
                $worksheet->getStyle($cellRange)->applyFromArray($style);

                // กำหนดขอบกรอบรอบข้อมูล
                $cellRange = 'A2:F' . $worksheet->getHighestRow();
                $style = [
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                        'inside' => [ // ขอบสัมพันธ์
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ];
                $worksheet->getStyle($cellRange)->applyFromArray($style);

          
                $cellRange = 'D2:D7'; 
                $worksheet->mergeCells($cellRange);
                $cellRange = 'E2:E7'; 
                $worksheet->mergeCells($cellRange);
                $cellRange = 'F2:F7';
                $worksheet->mergeCells($cellRange);
                
            },
        ];
    }
}
