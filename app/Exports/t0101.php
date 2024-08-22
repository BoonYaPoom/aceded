<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class t0101 implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $department_id;
    protected $year;
    protected $provin_name;

    public function __construct($department_id, $provin_name, $year)
    {
        $this->department_id = $department_id;
        $this->year = $year;
        $this->provin_name = $provin_name;
    }
    public function collection()
    {
        $learner = DB::table('users')
            ->join('course_learner', 'users.user_id', '=', 'course_learner.user_id')
            ->join('users_extender2', 'users.organization', '=', 'users_extender2.extender_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('course', 'course_learner.course_id', '=', 'course.course_id')
            ->where('course_learner.learner_status', '=', 1)
            ->where('users.user_role', 4)
            ->where('course_learner.course_id', '>', 0)
            ->where('provinces.name_in_thai', '=', $this->provin_name)
            ->select(
                'users.username',
                'users.firstname',
                'users.lastname',
                'department.name_th',
                'users_department.department_id',
                'users_extender2.name as exten_name',
                'course.course_th as course_th',
                'provinces.name_in_thai as province_name',
                DB::raw("TO_CHAR(course_learner.registerdate, 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as register_date"),
                DB::raw("TO_CHAR(course_learner.realcongratulationdate , 'DD Month YYYY ', 'NLS_DATE_LANGUAGE=THAI') as realcongratulationdate"),
                DB::raw('EXTRACT(YEAR FROM course_learner.registerdate)  + 543  as year'),
            );
            if($this->department_id == 0){
            $datauser = $learner->whereRaw('EXTRACT(YEAR FROM course_learner.registerdate) + 543 = ?', [$this->year])
            ->distinct()
            ->get();
            }else{
            $datauser = $learner->whereRaw('EXTRACT(YEAR FROM course_learner.registerdate) + 543 = ?', [$this->year])
                ->where('users_department.department_id', '=', $this->department_id)
                ->distinct()
                ->get();
            }
     


        $i = 1;
        $datauserAll = $datauser->map(function ($item) use (&$i) {
            $fullname =  $item->firstname . ' ' . $item->lastname;
            $exten2 = $item->exten_name;
            $course_th = $item->course_th;
            $register_date = $item->register_date;
            $realcongratulationdate = $item->realcongratulationdate;

            return [
                'i' => $i++,
                'fullname' => $fullname,
                'exten2' => $exten2,
                'course_th' =>  $course_th,
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
            'ชื่อ-นามสกุล',
            'สังกัด',
            'หลักสูตร',
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
