<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiDepartment(){
        $departapi = Department::all();
        return response()->json($departapi);
    }
}
