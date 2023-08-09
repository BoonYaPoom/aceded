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
    public function departmentcreate() {

        return view('layouts.department.create');
    }
    public function store(Request $request) {

        $depart = new Department;
        $depart->name_th = $request->name_th;
        $depart->name_en = $request->name_en;

        $depart->name_short_en = $request->name_short_en;
        $depart->department_id_ref = $request->department_id_ref;
        $depart->department_status = $request->input('department_status', 0);
        if ($request->hasFile('name_short_th')) {
            $image = $request->file('name_short_th');
            $imageName = time() . '_' . $image->getClientOriginalName();
           $image->move(public_path('uploads'), $imageName);

        }
        $depart->name_short_th = $imageName;
        $depart->save();

        return redirect()->route('departmentpage')->with('message','success Department control');
    }
    public function departmentedit($department_id) {
        $depart  = Department::findOrFail($department_id);
        return view('layouts.department.edit',compact('depart'));
    }
    public function update(Request $request ,$department_id) {

        $depart =  Department::findOrFail($department_id);
        $depart->name_th = $request->name_th;
        $depart->name_en = $request->name_en;

        $depart->name_short_en = $request->name_short_en;
        $depart->department_id_ref = $request->department_id_ref;
        $depart->department_status = $request->input('department_status', 0);
        if ($request->hasFile('name_short_th')) {
            $image = $request->file('name_short_th');
            $imageName =  $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);

        }
        $depart->name_short_th = $imageName;
        $depart->save();

        return redirect()->route('departmentpage')->with('message','success Department control');
    }


    
}
