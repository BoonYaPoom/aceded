<?php

namespace App\Http\Controllers\ReportDepartment;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportBDPController extends Controller
{
    public function Reportview($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('layouts.department.item.data.report2.index', compact('depart'));
    }
    
}
