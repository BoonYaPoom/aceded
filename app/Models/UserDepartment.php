<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;
    protected $table = 'users_department';
    protected $primaryKey = 'user_department_id';
    protected $guarded =[];

    public $timestamps = false;
}
