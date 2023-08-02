<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $guarded =[];

    public $timestamps = false;
    public function Catsub() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
      public function topics()
      {
          return $this->hasMany(CategoryTopic::class, 'category_id');
      }
      
}
