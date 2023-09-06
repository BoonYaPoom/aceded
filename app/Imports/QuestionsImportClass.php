<?php

namespace App\Imports;

use App\Models\CourseSubject;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionsImportClass implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $subjectId;
    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    public function model(array $row)
    {
        // ใช้ $this->subjectId เพื่อเข้าถึงค่า subject_id ที่ถูกส่งเข้ามา
        $subjectId = $this->subjectId;

        if ($row[0] <= 2) {
        return DB::transaction(function () use ($row,$subjectId) {
            $lastQuestionId = Question::max('question_id');


            $questionType = 1;
            $questionStatus = 1;
            $score = 0;
            $numChoice = 5;
            $Choice6 = null;
            $Choice7 = null;
            $Choice8 = null;
            $ordering = null;
            $explainquestion = null;
            $lessonId = 0;
            $question_level = 0;

            return new Question([
                'question_id' => $lastQuestionId + 1,
                'question' => $row['1'],
                'choice1' => $row['2'],
                'choice2' => $row['3'],
                'choice3' => $row['4'],
                'choice4' => $row['5'],
                'choice5' => $row['6'],
                'answer' => $row['7'],
                'explain' => $row['8'],
                'choice6' => $Choice6,
                'choice7' => $Choice7,
                'choice8' => $Choice8,
                'question_type' => $questionType,
                'question_status' => $questionStatus,
                'score' => $score,
                'numchoice' => $numChoice,
                'ordering' => $ordering,
                'explainquestion' => $explainquestion,
                'lesson_id' => $lessonId,
                'subject_id' => $subjectId,
                'question_level' => $question_level,

            ]);
        });
    }
    }
}
