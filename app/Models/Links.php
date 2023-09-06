<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;
    protected $table = 'links';
    protected $guarded =[];
    protected $primaryKey = 'links_id';
    public $timestamps = false;

    public function Department() {
        return $this->belongsTo(Department::class,'department_id');
      }
}
