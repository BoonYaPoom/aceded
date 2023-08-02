<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogId extends Model
{
    use HasFactory;
    
    protected $table = 'logid';
    protected $guarded =[];
    protected $primaryKey = 'logid';
    public $timestamps = false;
    public function logdd() {
        return $this->hasMany(Log::class,'logid');
      }
}
