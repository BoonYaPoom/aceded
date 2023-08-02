<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSupplymentaryType extends Model
{
    use HasFactory;
    protected $table = 'course_supplymentary_type';
    protected $primaryKey = 'supplymentary_type';
    protected $guarded =[];

    public $timestamps = false;

    public function suptype()
    {
        return $this->hasMany(CourseSupplymentary::class,'supplymentary_type');
    }
}
