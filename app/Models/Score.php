<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;



    use HasFactory;
    protected $table = 'score';
    protected $guarded =[];
    protected $primaryKey = 'score_id';
    public $timestamps = false;
    public function examlog() {
        return $this->belongsTo(Exam::class,'exam_id');
      }
}
