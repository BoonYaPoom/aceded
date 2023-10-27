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
            [2, 'รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)', ''],
            [3, 'รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน', ''],
            [4, 'รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร (ช่วงที่ 1 อายุไม่เกิน 11 ปี / ช่วงที่ 2 อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป)', ''],
            [5, 'รายงานสถิติการเข้าใช้งานรายเดือน (ผู้ใช้งานใหม่)', ''],
            [6, 'รายงานสถิติการเข้าใช้งานรายไตรมาส (ผู้ใช้งานใหม่)', ''],
            [7, 'รายงานสถิติการเข้าใช้งานรายเดือน (ผู้ใช้งานใหม่)', ''],
            [8, 'รายงานสถิติการเข้าใช้งานรายเดือน (กลุ่มบุคลากรภาครัฐ และรัฐวิสาหกิจ)', ''],
            [9, 'รายงานสถิติการเข้าใช้งานรายเดือน (กลุ่มการศึกษาขั้นพื้นฐาน)', ''],
            [10, 'รายงานสถิติการเข้าใช้งานรายเดือน (กลุ่มอุดมศึกษา)', ''],
            [11, 'รายงานสถิติการเข้าใช้งานรายเดือน (กลุ่มอาชีวศึกษา)', ''],
            [12, '	รายงานสถิติการเข้าใช้งานรายเดือน (กลุ่มโค้ช และประชาชน)', ''],
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
                $cellRange = 'A1:C1';

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
                $cellRange = 'A2:C' . $worksheet->getHighestRow();
                $style = [
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
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

          
           
                
            },
        ];
    }
}
