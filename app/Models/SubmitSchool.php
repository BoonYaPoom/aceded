<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitSchool extends Model
{
    use HasFactory;
    protected $table = 'submit_school';
    protected $guarded =[];
    protected $primaryKey = 'submit_id';
    public $timestamps = false;
}
