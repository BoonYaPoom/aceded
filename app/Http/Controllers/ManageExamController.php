<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageExamController extends Controller
{
    public function ManageExam($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.index', compact('depart'));
    }
    public function Create($department_id)
    {
        DB::commit();

    
        try {
            $manuals = new Department;

       
            $manuals->save();
        
    
            DB::commit();
        } catch (\Exception $e) {
    
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    


        return redirect()->route('manualpage')->with('message', 'manuals บันทึกข้อมูลสำเร็จ');
    
    }
    public function store($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.index', compact('depart'));
    }
    public function edit($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.edit', compact('depart'));
    }
    public function update($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('page.manageExam.index', compact('depart'));
    }
    
}
