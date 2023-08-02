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
        $ques = Question::select('question_id', 'question', 'question_type.question_type_th', 'course_lesson.lesson_th', 'question_status')
        ->join('question_type', 'question.question_type', '=', 'question_type.question_type')
        ->join('course_lesson', 'question.lesson_id', '=', 'course_lesson.lesson_id')
        ->get()
        ->map(function ($item, $index) {
            $item->question_id = $index + 1;
            $item->question_status = $item->question_status == 1 ? 'on' : 'off';

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





