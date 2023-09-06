<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;
    protected $table = 'course_lesson';
    protected $primaryKey = 'lesson_id';
    protected $guarded =[];

    public $timestamps = false;

    public function lessos() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
    public function lessostype() {
        return $this->belongsTo(ContentType::class,'content_type')->select(['content_type', 'content_th']);
      }

      public function supplyLesson()
      {
          return $this->hasMany(CourseSupplymentary::class,'lesson_id');
      }
}
