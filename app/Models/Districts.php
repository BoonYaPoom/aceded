<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $fillable = [
        'code',
        'name_in_thai',
        'name_in_english',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'province_id');
    }
    public $timestamps = false;


      public function userdist()
      {
          return $this->hasMany(User::class,'district_id');
      }
}
