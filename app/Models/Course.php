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
      public function classCouse()
      {
          return $this->hasMany(Course::class,'course_id');
      }
      public static function generateCourseCode()
{
    $count = static::count() + 1;
    $code = 'ACED' . str_pad($count, 3, '0', STR_PAD_LEFT);
    return $code;
}
    
}
