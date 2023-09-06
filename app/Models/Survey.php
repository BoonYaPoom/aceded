<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $table = 'survey';
    protected $guarded =[];
    protected $primaryKey = 'survey_id';
    public $timestamps = false;
    public function surs()
    {
        return $this->hasMany(SurveyQuestion::class, 'survey_id');
    }
    public function Department() {
        return $this->belongsTo(Department::class,'department_id');
      }
    public function surRes()
    {
        return $this->hasMany(SurResponse::class, 'survey_id');
    }
    
    public function subjectsur() {
        return $this->belongsTo(CourseSubject::class,'survey_id');
      }
}
