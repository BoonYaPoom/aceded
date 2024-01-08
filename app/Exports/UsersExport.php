<?php


namespace App\Exports;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\Provinces;
use App\Models\UserDepartment;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Carbon\Carbon;
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
        $users = DB::table('users')->select('user_id', 'username', 'firstname', 'lastname', 'createdate', 'province_id', 'mobile', 'organization', 'user_affiliation', 'userstatus')
            ->get();
        $i = 1;
        $datauser = $users->map(function ($item) use (&$i) {
            $proviUser = Provinces::where('id', $item->province_id)->value('name_in_thai') ?? '-';
            $extender2 = Extender2::where('extender_id', $item->organization)->value('name') ?? '-';
            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $fullname =  $firstname . '' . '-' . '' . $lastname;
            $mobile = $item->mobile;

            $part1 = substr($mobile, 0, 3);
            $part2 = substr($mobile, 3, 3);
            $part3 = substr($mobile, 6, 4);
            $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
            $createdate = Carbon::createFromFormat('Y-m-d H:i:s', $item->createdate)->format('d/m/') . (Carbon::parse($item->createdate)->year + 543);
            return [
                'i' => $i + 1,
                'username' => $item->username,
                'fullname' => $fullname,
                'mobile' => $fullMobile,
                'extender2' => $extender2,
                'user_affiliation' => $item->user_affiliation ?? '-',
                'proviUser' => $proviUser,
                'createdate' => $createdate,
                'status' => $item->userstatus,
            ];
        });
    
        return $datauser;
    }

    public function headings(): array
    {
        return [
            'ลำดับ',
            'รหัสผู้ใช้',
            'ชื่อ-นามสกุล',
            'เบอร์',
            'ระดับ',
            'หน่วยงาน',
            'จังหวัด',
            'วันที่สร้าง',
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
