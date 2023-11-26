<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $guarded =[];
    protected $primaryKey = 'id';
    public function districts()
    {
        return $this->hasMany(Districts::class, 'province_id');
    }
    public $timestamps = false;

    
    public function userpor()
    {
        return $this->hasMany(Users::class,'province_id');
    }
    public function schoolpor()
    {
        return $this->hasMany(School::class,'provinces_code');
    }
}
