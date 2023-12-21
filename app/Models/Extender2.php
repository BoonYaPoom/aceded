<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extender2 extends Model
{
    use HasFactory;
    protected $table = 'users_extender2';
    protected $guarded = [];
    protected $primaryKey = 'extender_id';
    public $timestamps = false;
}
