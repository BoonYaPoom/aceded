<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;
    protected $table = 'survey_question';
    protected $primaryKey = 'question_id';
    protected $guarded =[];

    public $timestamps = false;
    public function sursq() {
        return $this->belongsTo(Survey::class,'survey_id');
      }
      public function subjectsur() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
      public function typequs() {
        return $this->belongsTo(QuestionType::class,'question_type');
      }
}
