<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
    use HasFactory;
    protected $table = 'course_group';
    protected $primaryKey = 'group_id';
    protected $guarded =[];

    public $timestamps = false;
    public function group()
    {
        return $this->hasMany(Course::class,'group_id');
    }
    public function DepartGruo() {
        return $this->belongsTo(Department::class,'department_id');
      }
}
