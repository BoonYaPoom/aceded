<?php

namespace App\Exports;

use App\Models\CourseLearner;
use App\Models\PersonType;
use App\Models\Users;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
class LearnerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\FromCollection
     */
    use Exportable;

    public function collection()
    
    {


        $learners =  CourseLearner::all();
        $data = collect([]);
        $n = 1;
 ;
        $result = []; // สร้างตัวแปรเก็บผลลัพธ์
        $uniqueUserIds = [];
        $users = null;
        $UserSchool = null;
        $schoolName = null;
        $learners = CourseLearner::all();

        foreach ($learners as $l => $learns) {

            $dataLearn = $learns->registerdate;
            $congrateLearn = $learns->congratulationdate;
            $congrate = $learns->congratulation;
            $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
            $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
            $users = \App\Models\Users::find($learns->user_id);

            if ($users) {
                $UserSchool = \App\Models\UserSchool::with('schouser')
                    ->where('user_id', $users->user_id)
                    ->first();

                if ($UserSchool) {
                    $schoolName = optional($UserSchool->schouser)->school_name;
                } else {
                    $schoolName = [];
                }
            } else {
                $schoolName = [];
            }

            $courses = \App\Models\Course::find($learns->course_id);

            if ($courses) {
                // Access properties of the $courses object here
                $course_th = $courses->course_th;
                // ...
            } else {
            }
            $carbonDate = \Carbon\Carbon::parse($congrateLearn);
            $thaiDate = $carbonDate->locale('th')->isoFormat('D MMMM');
            $buddhistYear = $carbonDate->addYears(543)->year;
            $thaiYear = $buddhistYear > 0 ? $buddhistYear : '';
            $thaiDateWithYear = $thaiDate . ' ' . $thaiYear;

            $carbonDa = \Carbon\Carbon::parse($dataLearn);
            $thaiDa = $carbonDa->locale('th')->isoFormat('D MMMM');
            $buddhistYe = $carbonDa->addYears(543)->year;
            $thai = $buddhistYe > 0 ? $buddhistYe : '';
            $thaiDat = $thaiDa . ' ' . $thai;

            if (isset($users) && $users) {
                $data->push([
                    $n++,
                    optional($users)->username ?? '-',
                    optional($users)->firstname ?? '-' -  optional($users)->lastname ?? '-',
                   
                    $schoolName ?? '-',
                    optional($courses)->course_th ?? '-',
                    $thaiDat ?? '-',
                    $congrate == 1 ? $thaiDateWithYear : '-',
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ลำดับ.',
            'ชื่อผู้ใช้งาน',
            'ชื่อ - สกุล',
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
