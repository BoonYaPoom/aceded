<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTopic extends Model
{
    use HasFactory;
    protected $table = 'category_topic';
    protected $primaryKey = 'topic_id';
    protected $guarded = [];
    public $timestamps = false;
    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

}
