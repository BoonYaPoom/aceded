<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Models\Course;
use App\Models\CourseFavorites;
use App\Models\CourseLearner;
use App\Models\Department;
use App\Models\Log;
use App\Models\PersonType;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartReportController extends Controller
{
    public function DepartReportview($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('layouts.department.item.data.report.index',compact('depart'));
    }
    public function DepartReportA($department_id)
    {
        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        
        $count1 = $userper->where('user_role', 1)->count();
        $count3 = $userper->where('user_role', 3)->count();
        $count4 = $userper->where('user_role', 4)->count();
        
        $user_role1 = $userper->where('user_role', 1)->first();
        $user_role3 = $userper->where('user_role', 3)->first();
        $user_role4 = $userper->where('user_role', 4)->first();
        
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();
        $learners =  CourseLearner::all();
        return view('layouts.department.item.data.report.reporta', compact('userper','depart', 'count1', 'count3', 'count4','user_role1','user_role3','user_role4', 'month', 'perType', 'learners'));
    }
    public function ReportB($department_id)
    {

    
        $logs = Log::all();
        $depart = Department::findOrFail($department_id);
        $bookcat  = $depart->BookCatDe()->where('department_id', $department_id)->get();
        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $count1 = Users::where('user_role', 1)->count();
        $count3 = Users::where('user_role', 3)->count();
        $count4 = Users::where('user_role', 4)->count();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();
        $cour = Course::all();
        $favorit =  CourseFavorites::all();
        $learners =  CourseLearner::all();
      
        $month = $monthdata['th'];
      
        return view('layouts.department.item.data.report.reportb', compact('depart','favorit','bookcat','cour','userper', 'count1', 'count3', 'count4', 'month', 'perType', 'learners', 'logs'));
    }

    public function ReportC($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();


        return view('layouts.department.item.data.report.reportc', compact('depart','userper'));
    }
}
