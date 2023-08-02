<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    use HasFactory;
    protected $table = 'book_category';
    protected $primaryKey = 'category_id';
    protected $guarded =[];

    public $timestamps = false;
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
