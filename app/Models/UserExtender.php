<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExtender extends Model
{
    use HasFactory;
    protected $table = 'users_extender';
    protected $primaryKey = 'extender_id';
    protected $guarded =[];

    public $timestamps = false;

    public function DeExten(){
        return $this->belongsTo(Department::class,'department_id');
    }
}
