<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLearner extends Model
{
    use HasFactory;
    protected $table = 'course_learner';
    protected $primaryKey = 'learner_id';
    protected $guarded =[];

    public $timestamps = false;
}
