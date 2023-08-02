<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSupplymentary extends Model
{
    use HasFactory;
    protected $table = 'course_supplymentary';
    protected $primaryKey = 'supplymentary_id';
    protected $guarded =[];

    public $timestamps = false;
    public function subsupply() {
        return $this->belongsTo(CourseSubject::class,'subject_id');
      }
    public function type() {
        return $this->belongsTo(CourseSupplymentaryType::class,'supplymentary_type');
      }
}
