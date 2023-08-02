<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';
    protected $primaryKey = 'question_id';
    protected $guarded =[];

    public $timestamps = false;
    public function typequs() {
        return $this->belongsTo(QuestionType::class,'question_type');
      }
      public function subjectquse() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
}
