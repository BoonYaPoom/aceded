<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $primaryKey = 'department_id';
    protected $guarded =[];

    public $timestamps = false;
    public function SubjectDe()
    {
        return $this->hasMany(CourseSubject::class,'department_id');
    }
    public function degroup()
    {
        return $this->hasMany(CourseGroup::class,'department_id');
    }
    public function hightlight()
    {
        return $this->hasMany(Highlight::class,'department_id');
    }
}
