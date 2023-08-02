<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'book';
    protected $primaryKey = 'book_id';
    protected $guarded =[];

    public $timestamps = false;
    public function bookcat() {
        return $this->belongsTo(BookCategory::class,'category_id');
      }
}
