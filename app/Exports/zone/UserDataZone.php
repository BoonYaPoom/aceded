<?php

namespace App\Exports\zone;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserDataZone implements

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

        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $zones = DB::table('user_admin_zone')->where('user_id', $data->user_id)->pluck('province_id')->toArray();
            $users = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users.user_role', 4)
                ->whereIn('users.province_id', $zones)
                ->leftJoin('provinces', 'provinces.id', '=', 'users.province_id')
                ->leftJoin('districts', 'districts.id', '=', 'users.district_id')
                ->leftJoin('subdistricts', 'subdistricts.id', '=', 'users.subdistrict_id')
                ->select(
                    'users_department.department_id',
                    'users_department.user_id',
                    'users.username',
                    'users.firstname',
                    'users.lastname',
                    'users.createdate',
                    'users.province_id',
                    'provinces.name_in_thai as provinces_name',
                    'districts.name_in_thai as districts_name',
                    'subdistricts.name_in_thai as subdistricts_name',
                    'users.mobile',
                    'users.organization',
                    'users.user_affiliation',
                    'users.userstatus',
                    DB::raw('EXTRACT(YEAR FROM users.createdate)  + 543  as year'),
                )->groupBy(
                    'users_department.department_id',
                    'users_department.user_id',
                    'users.username',
                    'users.firstname',
                    'users.lastname',
                    'users.createdate',
                    'users.province_id',
                    'provinces.name_in_thai',
                    'districts.name_in_thai',
                    'subdistricts.name_in_thai',
                    'users.mobile',
                    'users.organization',
                    'users.user_affiliation',
                    'users.userstatus',
                   
                )
                ->get();

            $i = 1;
            $datauser = $users->map(function ($item) use (&$i) {
                if ($item->department_id <= 5) {
                    if ($item->province_id > 0) {
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
                        $exten = DB::table('users_extender2')->where('extender_id', $item->organization)
                            ->leftJoin('provinces', 'provinces.id', '=', 'users_extender2.school_province')
                            ->leftJoin('districts', 'districts.id', '=', 'users_extender2.school_district')
                            ->leftJoin('subdistricts', 'subdistricts.id', '=', 'users_extender2.school_subdistrict')
                            ->select(
                                'users_extender2.item_parent_id as item_parent_id',
                                'users_extender2.name as exten_name',
                                'provinces.name_in_thai as provinces',
                                'districts.name_in_thai as districts',
                                'subdistricts.name_in_thai as subdistricts',
                            )
                            ->first();


                        if ($exten) {
                            $extender2 = DB::table('users_extender2')->where('extender_id', $exten->item_parent_id)->value('name') ?? '-';
                            $exten_name =  $exten->exten_name;
                            $subdistricts = $exten->subdistricts;
                            $districts = $exten->districts;
                            $provinces = $exten->provinces;
                        } else {
                            $extender2 = '-';
                            $exten_name = '-';
                            $subdistricts = '-';
                            $districts = '-';
                            $provinces = '-';
                        }

                        $exten2 = $exten_name .  ' / ' .  $extender2  .  ' / ' . $subdistricts . ' / ' . $districts  . ' / ' . $provinces;
                    } elseif ($item->province_id == 0) {
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('users_extender2')
                            ->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                            ->where('users_extender2.extender_id', $item->organization)
                            ->value('name_in_thai') ?? '-';
                        $exten = DB::table('users_extender2')->where('extender_id', $item->organization)
                            ->leftJoin('provinces', 'provinces.id', '=', 'users_extender2.school_province')
                            ->leftJoin('districts', 'districts.id', '=', 'users_extender2.school_district')
                            ->leftJoin('subdistricts', 'subdistricts.id', '=', 'users_extender2.school_subdistrict')
                            ->select(
                                'users_extender2.item_parent_id as item_parent_id' ?? '-',
                                'users_extender2.name as exten_name',
                                'provinces.name_in_thai as provinces',
                                'districts.name_in_thai as districts',
                                'subdistricts.name_in_thai as subdistricts',
                            )
                            ->first();

                        if ($exten) {
                            $extender2 = DB::table('users_extender2')->where('extender_id', $exten->item_parent_id)->value('name') ?? '-';
                            $exten_name =  $exten->exten_name;
                            $subdistricts = $exten->subdistricts;
                            $districts = $exten->districts;
                            $provinces = $exten->provinces;
                        } else {
                            $extender2 = '-';
                            $exten_name = '-';
                            $subdistricts = '-';
                            $districts = '-';
                            $provinces = '-';
                        }

                        $exten2 = $exten_name .  ' / ' .  $extender2  .  ' / ' . $subdistricts . ' / ' . $districts  . ' / ' . $provinces;
                    }
                } elseif ($item->department_id > 5) {
                    if (Str::contains($item->user_affiliation, 'ระดับ')) {
                        $exten2 = DB::table('users_extender2')->where('extender_id', $item->organization)->value('name') ?? '-';
                        $aff = $item->user_affiliation;
                        $proviUser = DB::table('provinces')->where('id', $item->province_id)->value('name_in_thai') ?? '-';
                    } else {
                        $extender2 = $item->user_affiliation;
                        $exten2 = $item->user_affiliation;
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

                $formattedDate = $createdate->format('Y-m-d');
                //  . ($createdate->year + 543);

                $formattedTime = ltrim($createdate->format('g.i'), '0')  . ' ' . 'น.';
                $TimeDAta =  $formattedDate . ' '  . ' ' . $formattedTime;

                $work_user = 'จังหวัด ' . $item->provinces_name . ' / ' . 'อำเภอ ' .  $item->districts_name . ' / ' . 'ตำบล ' . $item->subdistricts_name;

                return [
                    'i' => $i++,
                    'username' => $item->username,
                    'fullname' => $fullname,
                    'mobile' => $fullMobile,
                    'work_user' =>  $work_user,
                    'user_affiliation' => $aff,
                    'extender2' => $exten2,
                    'proviUser' => $proviUser,
                    'createdate' => $formattedDate,
                    'formattedTime' => $formattedTime,
                    'status' =>  $item->userstatus = 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน',
                ];
            });
        }
        set_time_limit(0);
        return $datauser;
    }

    public function headings(): array
    {
        return [
            'ลำดับ',
            'รหัสผู้ใช้',
            'ชื่อ-นามสกุล',
            'เบอร์',
            'มาจาก',
            'ระดับ',
            'หน่วยงาน',
            'จังหวัด',
            'วันที่สร้าง',
            'เวลา',
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
