<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    use HasFactory;
    protected $table = 'activity_category';
    protected $primaryKey = 'category_id';
    protected $guarded =[];

    public $timestamps = false;
    public function activa()
    {
        return $this->hasMany(Activity::class,'category_id');
    }
}
