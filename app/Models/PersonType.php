<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    use HasFactory;
    protected $table = 'person_type';
    protected $guarded =[];
    protected $primaryKey = 'person_type';
    public $timestamps = false;

    public function userpersons() {
        return $this->hasMany(Users::class,'user_type');
      }
}
