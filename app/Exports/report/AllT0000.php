<?php

namespace App\Exports\report;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AllT0000 implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct()
    {
    }
    public function collection()
    {
        $learner = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->join('provinces', 'provinces.id', '=', 'users_extender2.school_province')
            ->join('districts', 'districts.id', '=', 'users_extender2.school_district')
            ->join('subdistricts', 'subdistricts.id', '=', 'users_extender2.school_subdistrict')
            ->join('user_role', 'user_role.user_role_id', '=', 'users.user_role')
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
            ->whereNotIn('users.user_role', [1, 6, 7, 8, 9])
            ->select(
                'users.username',
                'users.firstname',
                'users.lastname',
                'users.user_affiliation',
                'department.department_id as department_id_ace',
                'users_department.department_id',
                'department.name_th as department_name',
                'users.organization as organization',
                'users_extender2.item_parent_id as item_parent_id',
                'users_extender2.name as exten_name',
                'provinces.name_in_thai as provinces',
                'districts.name_in_thai as districts',
                'subdistricts.name_in_thai as subdistricts',
                'course_learner.congratulation as congratulation',
                'course.course_th as course_th',
                'user_role.role_name',
                DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month ', 'NLS_DATE_LANGUAGE=THAI' ) as register_date"),
                DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month ', 'NLS_DATE_LANGUAGE=THAI' ) as realcongratulationdate"),
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
                DB::raw('EXTRACT(YEAR FROM course_learner.realcongratulationdate)  + 543  as yearcon'),
            )->orderBy('department_id_ace');

        $datauser = $learner
            ->distinct()
            ->get();


        $i = 1;
        $datauserAll = $datauser->map(function ($item) use (&$i) {
            $fullname =  $item->firstname . ' ' . $item->lastname;
            $username =  $item->username;
            if ($item->organization > 0) {
                $extender2 = DB::table('users_extender2')->where('extender_id', $item->item_parent_id)->value('name') ?? '-';
                $exten2 = $item->exten_name .  ' / ' .  $extender2 .  ' / ' . $item->subdistricts . ' / ' . $item->districts . ' / ' . $item->provinces;
            } elseif ($item->organization == 0 || $item->organization == null) {
                $exten2 = $item->user_affiliation;
            }
            $role_name = $item->role_name;
            $course_th = $item->course_th;
            $register_date = $item->register_date . ' ' . $item->year;
            $realcongratulationdate = $item->realcongratulationdate . ' ' . $item->yearcon;
            $department_name = $item->department_name;
            $congratulation = $item->congratulation;
            if ($congratulation == 0) {
                $cons = 'N/A';
                $cer = '-';
            } elseif ($congratulation == 1) {
                $cons = 'P';
                $cer = 'A';
            }
            return [
                'i' => $i++,
                'username' => $username,
                'fullname' => $fullname,
                'department_name' =>  $department_name,
                'exten2' => $exten2,
                'course_th' =>  $course_th,
                'cons' => $cons,
                'cer' => $cer,
                'register_date' => $register_date,
                'realcongratulationdate' => $realcongratulationdate,
            ];
        });

        return $datauserAll;
    }

    public function headings(): array
    {

        return [
            'ลำดับ',
            'ชื่อที่ใช้ในระบบ',
            'ชื่อ-นามสกุล',
            'หน่วยงาน',
            'สถานศึกษา',
            'หลักสูตรที่ลงทะเบียนเรียน',
            'สถานะการเรียน/จบ',
            'สถานะการได้ใบประกาศนียบัตร',
            'วันที่ลงทะเบียนเรียน',
            'วันที่จบหลักสูตร',
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
                $event->sheet->getStyle('A1:K1')->applyFromArray($alignment);

                // ต่อไปเพิ่มคอลัมน์อื่น ๆ ตามต้องการ

                // กำหนดความหนาของตัวหนังสือในทุกคอลัมน์
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
