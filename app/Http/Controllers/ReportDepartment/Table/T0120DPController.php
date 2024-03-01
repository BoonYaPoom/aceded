<?php

namespace App\Http\Controllers\ReportDepartment\Table;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class T0120DPController extends Controller
{
    public function T0120DP($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $provin = DB::table('provinces')->get();
        $learner = DB::table('users')
            ->join('provinces', 'users.province_id', '=', 'provinces.id')
            ->join('logs', 'users.user_id', '=', 'logs.user_id')
            ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
            ->join('department', 'users_department.department_id', '=', 'department.department_id')
            ->where('users_department.department_id', '=', $department_id)
            ->where('department.department_id', '=', $department_id)
            ->select(
                'department.department_id',
                'provinces.name_in_thai as province_name',
                DB::raw('COUNT( logs.user_id) as user_count'),
                DB::raw('EXTRACT(YEAR FROM logs.logdate)  + 543  as year'),
            )->groupBy(
                'department.department_id',
                'provinces.id',
                'provinces.name_in_thai',
                DB::raw('EXTRACT(YEAR FROM logs.logdate)')
            )
            ->orderBy(DB::raw('EXTRACT(YEAR FROM logs.logdate)'), 'ASC')
            ->get();



        return view('layouts.department.item.data.report2.C.table.t0120dp', compact('provin', 'learner', 'depart'));
    }
}
