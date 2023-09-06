<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    protected $guarded =[];

    public $timestamps = false;
    public function cour() {
        return $this->belongsTo(CourseGroup::class,'group_id');
      }
    public function depart() {
        return $this->belongsTo(Department::class,'department_id');
      }
      public function classCouse()
      {
          return $this->hasMany(CourseClass::class,'course_id');
      }
      public function learnCouse()
      {
          return $this->hasMany(CourseLearner::class,'course_id');
      }
      public static function generateCourseCode($department_id)
      {
          $code = static::count() + 1;
        
          return $code;
      }
      
      
    
}
