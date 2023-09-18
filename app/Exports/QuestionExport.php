<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Question;
use Illuminate\Support\Facades\DB;


class QuestionExport implements  

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
        $ques = Question::select('question_id', 'question', 'question_type', 'lesson_id', 'question_status')

        ->get()
        ->map(function ($item, $index) {
            $item->question_id = $index + 1;
            $item->question_status = $item->question_status == 1 ? 'on' : 'off';
            $item->lesson_id = $item->lesson_id == 0 ? 'ข้อสอบ' : 'แบบทดสอบ';
            if ($item->question_type == 1) {
                $questionType = 'ปรนัย';
            } elseif ($item->question_type == 2) {
                $questionType = 'อัตนัย';
            } elseif ($item->question_type == 3) {
                $questionType = 'ถูกผิด';
            } elseif ($item->question_type == 4) {
                $questionType = 'จับคู่';
            } elseif ($item->question_type == 5) {
                $questionType = 'เรียงลำดับ';
            } else {
                $questionType = 'ไม่รู้จักประเภท';
            }
            $item->question_type =  $questionType ;
                    return $item;
        });
    
    
        return $ques;
    }
    public function headings(): array
    {
        return [
           'ลำดับ',
            'คำถาม',
            'ประเภท',
            'ชนิด',
            'สถานะ',
            'กระทำ',
            // เพิ่มหัวตารางอื่น ๆ ตามต้องการ
        ];
    }
    public function registerEvents(): array{
return [
    AfterSheet::class => function(AfterSheet $event){
        $event->sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true
            ]
            ]);
    }
];
}
}





