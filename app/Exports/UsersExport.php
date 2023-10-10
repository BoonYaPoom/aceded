<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class UsersExport implements
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
        $users = Users::select('user_id', 'username', DB::raw("firstname || ' - ' || lastname as full_name"), 'mobile', 'email', 'userstatus')
            ->get()
            ->map(function ($item, $index) {
                $item->user_id = $index + 1;
                $item->userstatus = $item->userstatus == 1 ? 'on' : 'off';
                return $item;
            });



        return $users;
    }

    public function headings(): array
    {
        return [
            'ลำดับ',
            'รหัสผู้ใช้',
            'ชื่อ-นามสกุล',
            'เบอร์',
            'email',
            'สถานะ',
            'กระทำ',
            // เพิ่มหัวตารางอื่น ๆ ตามต้องการ
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
            $event->sheet->getStyle('A1:G1')->applyFromArray($alignment);
   
            // ต่อไปเพิ่มคอลัมน์อื่น ๆ ตามต้องการ

            // กำหนดความหนาของตัวหนังสือในทุกคอลัมน์
            $event->sheet->getStyle('A1:G1')->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
            ]);
        },
    ];
    }
}
