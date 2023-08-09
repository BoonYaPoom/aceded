<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\General;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function manage()
    {
        return view('page.manages.manage');
    }

    public function dataci()
    {
        $genaral = General::all();
        return view('page.manages.data.dataci',compact('genaral'));
    }



    public function imghead()
    {
        return view('page.manages.data.imghead.imgheadedit');
    }
    public function dls()
    {
        return view('page.dls.index');
    }
    public function cop(){
        return view('page.dls.cop.index');
    }
  
   
    public function learn($department_id){
        $depart = Department::FindOrFail($department_id);
        return view('page.manage.index',compact('depart'));
    }
    public function home(){
        return view('layouts.adminhome');
    }
    public function activitypage($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        return view('page.manage.sub.activitys.index',compact('subs'));
    }
}
