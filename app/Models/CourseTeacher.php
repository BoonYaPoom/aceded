<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    use HasFactory;
    protected $table = 'course_teacher';
    protected $primaryKey = 'teacher_id';
    protected $guarded =[];

    public $timestamps = false;

    public function teactjs()
    {
        return $this->belongsTo(CourseSubject::class,'subject_id');
    }
}
