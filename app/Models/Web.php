<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory;
    protected $table = 'web';
    protected $guarded =[];
    public $timestamps = false;
    
    protected $primaryKey = 'web_id';
    public function category() {
        return $this->belongsTo(WebCategory::class,'category_id');
      }
}
