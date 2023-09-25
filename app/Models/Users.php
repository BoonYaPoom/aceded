<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $guarded =[];

    public $timestamps = false;

    public function dists() {
        return $this->belongsTo(Districts::class,'id');
      }
      public function pors() {
        return $this->belongsTo(Provinces::class,'id');
      }
      public function loguser() {
        return $this->hasMany(Log::class,'user_id');
      }
      public function perid() {
        return $this->belongsTo(PersonType::class,'person_type');
      }
      public function DepartUs() {
        return $this->belongsTo(Department::class,'department_id');
      }




}
