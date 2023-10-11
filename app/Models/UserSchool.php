<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSchool extends Model
{
    use HasFactory;
    
    protected $table = 'user_school';
    protected $guarded =[];
    protected $primaryKey = 'user_school_id';
    public $timestamps = false;
    public function schouser() {
        return $this->belongsTo(School::class,'school_id');
      }
      public function usersChool() {
        return $this->belongsTo(Users::class,'user_id');
      }
      public function DeSchouser() {
        return $this->hasMany(Department::class,'department_id');
      }
}
