<?php

namespace App\Imports;

use App\Models\CourseSubject;
use App\Models\Question;

use Maatwebsite\Excel\Concerns\ToModel;

class QuestionsImportClass implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] <= 2) {
        $questionType = 1 ;
        $questionStatus = 1 ;
        $questionType = 1 ;
        $score = '' ;
        $numChoice = 5 ;
        $Choice6 = null ;
        $Choice7 = null ;
        $Choice8 = null ;
        $ordering = null ;
        $explainquestion = null ;
        $lessonId = 1; 
        $SessonId = CourseSubject::findOrFail('subject_id'); 
        $lastQuestionId = Question::max('question_id'); 
        

        return new Question([
            'question_id' =>  $lastQuestionId + 1, 
            'question' => $row['1'],
            'choice1' => $row['2'],
            'choice2' => $row['3'],
            'choice3' => $row['4'],
            'choice4' => $row['5'],
            'choice5' => $row['6'],
            'answer' => $row['7'],
            'explain' => $row['8'],
            'question_type' => $questionType,
            'question_status' => $questionStatus,
            'score' => $score,
            'numchoice' => $numChoice,
            'choice6' => $Choice6,
            'choice7' => $Choice7,
            'choice8' => $Choice8,
            'ordering' => $ordering,
            'explainquestion' => $explainquestion,
            'lesson_id' =>  $lessonId,
            'subject_id' =>  $SessonId,
         
        ]);
    }
    }
}
