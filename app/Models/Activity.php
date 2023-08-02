<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activity';
    protected $primaryKey = 'activity_id';
    protected $guarded =[];

    public $timestamps = false;
    public function actcat() {
        return $this->belongsTo(ActivityCategory::class,'category_id');
      }
      public function act()
      {
          return $this->hasMany(ActivityInvite::class,'activity_id');
      }
}
