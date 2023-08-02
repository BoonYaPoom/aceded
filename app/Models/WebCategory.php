<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCategory extends Model
{
    use HasFactory;
    protected $table = 'web_category';
    protected $guarded =[];

    protected $primaryKey = 'category_id';

    public $timestamps = false;

    public function webs()
    {
        return $this->hasMany(Web::class, 'category_id');
    }
}
