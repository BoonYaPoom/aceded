<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;
    protected $table = 'manual';
    protected $guarded =[];
    protected $primaryKey = 'manual_id';
    public $timestamps = false;
    public function Department() {
        return $this->belongsTo(Department::class,'department_id');
      }
}
