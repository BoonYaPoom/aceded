<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFavorites extends Model
{
    use HasFactory;
    protected $table = 'course_favorites';
    protected $primaryKey = 'favorites_id';
    protected $guarded =[];

    public $timestamps = false;

}
