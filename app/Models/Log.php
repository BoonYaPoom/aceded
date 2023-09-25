<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $guarded =[];
    protected $primaryKey = 'logsid';
    public $timestamps = false;
    public function logsa() {
        return $this->belongsTo(Users::class,'user_id');
      }
    public function logid() {
        return $this->belongsTo(LogId::class,'logid');
      }
    public function logtion() {
        return $this->belongsTo(Logaction::class,'actionid');
      }
}
