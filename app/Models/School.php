<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $table = 'school';
    protected $guarded =[];
    protected $primaryKey = 'school_id';
    public $timestamps = false;

    public function userScho()
    {
        return $this->hasMany(UserSchool::class, 'school_code');
    }
    public function DeScho() {
        return $this->belongsTo(School::class,'dewpartment_id');
      }
}
