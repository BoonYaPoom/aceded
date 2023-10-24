<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class ManageQuestionController extends Controller
{
    public function index($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.item.index', compact('depart'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.item.index', compact('depart'));
    }
    public function store($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.item.index', compact('depart'));
    }
    public function edit($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.item.index', compact('depart'));
    }
    public function update($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.item.index', compact('depart'));
    }
}
