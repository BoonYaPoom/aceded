<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function departmentpage() {
        $department  = Department::all();
     
        return view('layouts.department', compact('department'));
    }

}
