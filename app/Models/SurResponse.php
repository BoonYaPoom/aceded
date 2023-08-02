<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurResponse extends Model
{
    use HasFactory;
   
    protected $table = 'survey_response';
    protected $guarded =[];
    protected $primaryKey = 'response_id';
    public $timestamps = false;
    
    public function subREsoo() {
        return $this->belongsTo(Survey::class,'survey_id');
      }
}
