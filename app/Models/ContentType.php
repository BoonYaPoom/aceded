<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    use HasFactory;
    protected $table = 'content_type';
    protected $primaryKey = 'content_type';
    protected $guarded =[];

    public $timestamps = false;

    public function typecon()
    {
        return $this->hasMany(CourseLesson::class,'content_type');
    }
}
