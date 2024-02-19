<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Str;


class UserProvicAll implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $department_id;
    protected $provicValue;

    public function __construct($provicValue)
    {
        $this->provicValue = $provicValue;
    }
    public function collection()
    {
        if (Session::has('loginId')) {
            $data =
                DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $provicValue = $data->province_id;
            $users = DB::table('users')
                ->where('users.province_id', $provicValue)
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
                )->groupBy(
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
                )->get();

            $i = 1;
            $datauser = $users->map(function ($item) use (&$i) {
                if ($item->organization > 0) {
                    if ($item->province_id > 0) {
                        $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
                    } elseif ($item->province_id == 0) {
                        $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('users_extender2')
                            ->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                            ->where('users_extender2.extender_id', $item->organization)
                            ->value('name_in_thai') ?? '-';
                    }
                } elseif ($item->organization == 0) {
                    if (Str::contains($item->user_affiliation, 'ระดับ')) {
                        $extender2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
                    } else {
                        $extender2 = $item->user_affiliation;
                        $aff = '-';
                        $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
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
                    'i' => $i++,
                    'username' => $item->username,
                    'fullname' => $fullname,
                    'mobile' => $fullMobile,
                    'user_affiliation' =>  $aff,
                    'extender2' => $extender2,
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
