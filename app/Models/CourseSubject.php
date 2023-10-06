<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubject extends Model
{
    use HasFactory;
    
    protected $table = 'course_subject';
    protected $primaryKey = 'subject_id';
    protected $guarded =[];

    public $timestamps = false;

    public function subjs()
    {
        return $this->hasMany(CourseLesson::class,'subject_id');
    }
    public function Department() {
        return $this->belongsTo(Department::class,'department_id');
      }
    public function eam()
    {
        return $this->hasMany(Exam::class,'subject_id');
    }
    public function supplysub()
    {
        return $this->hasMany(CourseSupplymentary::class,'subject_id');
    }
    public function suyvsques()
    {
        return $this->hasMany(SurveyQuestion::class, 'subject_id');
    }
    public function QuestiSub()
    {
        return $this->hasMany(Question::class, 'subject_id');
    }
    public function suyvs()
    {
        return $this->hasMany(Survey::class, 'subject_id');
    }
    public function teachersup()
    {
        return $this->hasMany(CourseTeacher::class, 'subject_id');
    }
    public function Catt()
    {
        return $this->hasMany(Category::class, 'subject_id');
    }
  
}
