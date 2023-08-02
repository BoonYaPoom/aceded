<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    use HasFactory;
    protected $table = 'course_class';
    protected $primaryKey = 'class_id';
    protected $guarded =[];

    public $timestamps = false;
    public function coCourse() {
        return $this->belongsTo(Course::class,'course_id');
      }
}
