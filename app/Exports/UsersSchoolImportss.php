<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsersSchoolImportss implements FromCollection,
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
        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
          
            $organization = $data->organization;
            $users = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $this->department_id)
                ->where('users.organization', $organization)
                ->select(
                    'users.user_id',
                    'users.username',
                    'users.firstname',
                    'users.lastname',
                    'users.createdate',
                    'users.province_id',
                    'users.mobile',
                    'users.organization',
                    'users.user_affiliation',
                    'users.userstatus'
                )
                ->get();


            $i = 1;
            $datauser = $users->map(function ($item) use (&$i) {
                $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
                $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
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
                    'extender2' => $extender2,
                    'user_affiliation' => $item->user_affiliation ?? '-',
                    'proviUser' => $proviUser,
                    'createdate' => $TimeDAta,
                    'status' => $item->userstatus,
                ];
            });

            return $datauser;
        } else {
            $users = collect();
        }
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

