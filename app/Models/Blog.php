<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    protected $guarded =[];

    public $timestamps = false;
   
    public function blogcat() {
        return $this->belongsTo(BlogCategory::class,'category_id');
      }
}
