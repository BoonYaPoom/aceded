<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $fillable = [
        'code',
        'name_in_thai',
        'name_in_english',
    ];

    public function districts()
    {
        return $this->hasMany(Districts::class, 'province_id');
    }
    public $timestamps = false;

    
    public function userpor()
    {
        return $this->hasMany(User::class,'province_id');
    }
}
