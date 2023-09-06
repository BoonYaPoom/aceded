<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;
    protected $table = 'question_type';
    protected $primaryKey = 'question_type';
    protected $guarded = [];

    public $timestamps = false;
    public function qutype()
    {
        return $this->hasMany(Question::class, 'question_type');
    }
}
