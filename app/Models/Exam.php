<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exam';
    protected $primaryKey = 'exam_id';
    protected $guarded =[];

    public $timestamps = false;

    public function subexam() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
      public function scorelog()
      {
          return $this->hasMany(Score::class,'exam_id');
      }
}
