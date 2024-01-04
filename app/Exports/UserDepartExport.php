<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class UserDepartExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $department_id;


    public function __construct($department_id)
    {
        $this->department_id = $department_id;
    }
    public function collection()
    {
        // ถ้า user_role เป็น 1 แสดงผู้ใช้ทั้งหมดในแผนก
        $depart = Department::findOrFail($this->department_id); // เข้าถึง $department_id ด้วย $this->department_id


        $usermanages = $depart->UserDe()->where('department_id', $this->department_id)->get();

        $users = Users::select('user_id', 'username', DB::raw("firstname || ' - ' || lastname as full_name"), 'mobile','email', 'user_affiliation', 'userstatus')
            ->whereIn('user_id', $usermanages->pluck('user_id'))
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
            'หน่วยงาน',
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
