<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityInvite extends Model
{
    use HasFactory;
    protected $table = 'activity_invite';
    protected $primaryKey = 'invite_id';
    protected $guarded =[];

    public $timestamps = false;
    public function activi() {
        return $this->belongsTo(Activity::class,'activity_id');
      }
}
