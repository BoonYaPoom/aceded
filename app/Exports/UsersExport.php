<?php


namespace App\Exports;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\Provinces;
use App\Models\UserDepartment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
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
            $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';

            if ($item->organization > 0) {
                $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                $aff = $item->user_affiliation;
            } elseif ($item->organization == 0) {
                if (Str::contains($item->user_affiliation, 'ระดับ')) {
                    $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                    $aff = $item->user_affiliation;
                } else {
                    $extender2 = $item->user_affiliation;
                    $aff = '-';
                }
            }

            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $fullname =  $firstname . '' . '-' . '' . $lastname;
            $mobile = $item->mobile;

            $part1 = substr($mobile, 0, 3);
            $part2 = substr($mobile, 3, 3);
            $part3 = substr($mobile, 6, 4);
            $fullMobile = $part1 . '-' . $part2 . '-' . $part3;
            $createdate = Carbon::createFromFormat('Y-m-d H:i:s', $item->createdate);

            $formattedDate = $createdate->format('d/m/') . ($createdate->year + 543);

            $formattedTime = ltrim($createdate->format('g.i'), '0')  . ' ' . 'น.';

            $TimeDAta =  $formattedDate . ' '  . ' ' . $formattedTime;
            return [
                'i' => $i + 1,
                'username' => $item->username,
                'fullname' => $fullname,
                'mobile' => $fullMobile,
                'user_affiliation' => $aff,
                'extender2' => $extender2,
                'proviUser' => $proviUser,
                'createdate' => $TimeDAta,
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
