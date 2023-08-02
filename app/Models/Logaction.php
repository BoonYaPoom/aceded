<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logaction extends Model
{
    use HasFactory;
    protected $table = 'logaction';
    protected $guarded =[];
    protected $primaryKey = 'actionid';
    public $timestamps = false;
    public function logact() {
        return $this->hasMany(Log::class,'actionid');
      }
}
