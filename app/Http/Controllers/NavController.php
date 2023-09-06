<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\General;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function manage($department_id)
{
 
        $depart = Department::findOrFail($department_id);
 

    return view('page.manages.manage', compact('depart'));
}


    public function dataci()
    {

        $genaral = General::all();
        return view('layouts.department.item.data.dataci',compact('genaral'));
    }



    public function imghead()
    {
        
        return view('layouts.department.item.data.imghead.imgheadedit');
    }
    public function dls($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('page.dls.index',compact('depart'));
    }
    public function cop($department_id){
        
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.index',compact('depart'));
    }
  
   
    public function learn($department_id){
        $depart = Department::FindOrFail($department_id);
        return view('page.manage.index',compact('depart'));
    }
    public function home(){
        return view('layouts.adminhome');
    }
    public function homedepartment($department_id){
        $depart = Department::FindOrFail($department_id);
        return view('layouts.department.layout.departmenthome',compact('depart'));
    }
    public function activitypage($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $department_id   = $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.activitys.index',compact('subs','depart'));
    }
}
