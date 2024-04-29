<?php

namespace App\Http\Controllers\Cer;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class CerController extends Controller
{
    function index($department_id){
        $depart = Department::findOrFail($department_id);

        return view('page.manage.cer.index', compact('depart'));
    }
}
