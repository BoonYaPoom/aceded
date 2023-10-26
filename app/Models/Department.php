<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

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
    public function webcatDe()
    {
        return $this->hasMany(WebCategory::class,'department_id');
    }
    public function LinksDe()
    {
        return $this->hasMany(Links::class,'department_id');
    }
    public function SurDe()
    {
        return $this->hasMany(Survey::class,'department_id');
    }
    public function ManualsDe()
    {
        return $this->hasMany(Manual::class,'department_id');
    }
    public function BookCatDe()
    {
        return $this->hasMany(BookCategory::class,'department_id');
    }
    public function BlogCatDe()
    {
        return $this->hasMany(BlogCategory::class,'department_id');
    }
    public function ActCatDe()
    {
        return $this->hasMany(ActivityCategory::class,'department_id');
    }
    public function UserDe()
    {
        return $this->hasMany(Users::class,'department_id');
    }
    public function SchouserDe() {
        
        return $this->hasMany(UserSchool::class,'department_id');
      }
      public function GenDe() {
        
        return $this->hasMany(General::class,'department_id');
      }
      public function SchoDe()
      {
          return $this->hasMany(School::class, 'department_id');
      }
}
