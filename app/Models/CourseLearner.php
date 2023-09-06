<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLearner extends Model
{
    use HasFactory;
    protected $table = 'course_learner';
    protected $primaryKey = 'learner_id';
    protected $guarded = [];

    public $timestamps = false;
    public function cclassLearn()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }




    public function leCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
