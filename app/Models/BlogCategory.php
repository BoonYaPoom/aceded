<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_category';
    protected $primaryKey = 'category_id';
    protected $guarded =[];

    public $timestamps = false;
   
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
    public function Department() {
        return $this->belongsTo(Department::class,'department_id');
      }
}
