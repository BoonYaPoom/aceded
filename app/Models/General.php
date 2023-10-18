<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    use HasFactory;
    protected $table = 'general';
    protected $guarded =[];
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function DeGen()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
