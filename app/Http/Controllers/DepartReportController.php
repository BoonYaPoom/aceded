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

        return view('layouts.department.item.data.report.index', compact('depart'));
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

        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $perType = PersonType::all();
        $learners =  CourseLearner::all();
        return view('layouts.department.item.data.report.reporta', compact('userper', 'depart', 'count1', 'count3', 'count4', 'user_role1', 'user_role3', 'user_role4', 'month', 'perType', 'learners'));
    }
    public function ReportB($department_id)
    {


        $logs = Log::all();
        $depart = Department::findOrFail($department_id);
        $bookcat  = $depart->BookCatDe()->where('department_id', $department_id)->get();
        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $count1 = $userper->where('user_role', 1)->count();
        $count3 = $userper->where('user_role', 3)->count();
        $count4 = $userper->where('user_role', 4)->count();

        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();
        $cour = Course::all();
        $favorit =  CourseFavorites::all();
        $learners =  CourseLearner::all();

        $month = $monthdata['th'];

        return view('layouts.department.item.data.report.reportb', compact('depart', 'favorit', 'bookcat', 'cour', 'userper', 'count1', 'count3', 'count4', 'month', 'perType', 'learners', 'logs'));
    }

    public function ReportC($department_id)
    {

        $depart = Department::findOrFail($department_id);


        $userper = $depart->UserDe()->where('department_id', $department_id)->get();


        return view('layouts.department.item.data.report.reportc', compact('depart', 'userper'));
    }

    public function ReportUserAuth($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $perType = PersonType::all();

        $learners =  CourseLearner::all();
        return view('layouts.department.item.data.report.tables.t0101', compact('depart', 'month', 'learners', 'perType', 'userper'));
    }
    public function trainUserAuth($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0108', compact('depart', 'oneYearsAgo', 'currentYear', 'month'));
    }
    public function bookUserAuth($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0103', compact('depart', 'userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function LoginUserAuth($department_id)
    {
        $depart = Department::findOrFail($department_id);

        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0104', compact('depart', 'month', 'oneYearsAgo', 'currentYear'));
    }

    public function getUserData(Request $request)
    {

        $selecteduser_id = $request->input('selected_user_id');
        $userperselected = Users::where('user_id', $selecteduser_id)->get();

        return response()->json(['user_data' => $userperselected]);
    }





    public function BackUserAuth($department_id)

    {

        $depart = Department::findOrFail($department_id);


        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        return view('layouts.department.item.data.report.tables.t0110', compact('depart', 'oneYearsAgo', 'currentYear', 'month'));
    }
    public function reportMUserAuth($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0111', compact('depart', 'userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function reportYeaAuth($department_id)
    {


        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $year = Carbon::now()->year;
        $Quarter1 = Carbon::create($year, 1, 1);
        $Quarter2 = Carbon::create($year, 4, 1);
        $Quarter3 = Carbon::create($year, 7, 1);
        $Quarter4 = Carbon::create($year, 10, 1);
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0112', compact('depart', 'userper', 'month', 'Quarter1', 'Quarter2', 'Quarter3', 'Quarter4', 'oneYearsAgo', 'currentYear'));
    }
    public function reportQuarterlyAuth($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        return view('layouts.department.item.data.report.tables.t0113', compact('depart', 'userper', 'currentYear', 'oneYearsAgo', 'month'));
    }
    public function BackupFullUserAuth($department_id)
    {

        $depart = Department::findOrFail($department_id);

        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('layouts.department.item.data.report.tables.t0114', compact('depart', 'userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function LogFileUserAuth($department_id)
    {
        $logs = Log::all();
        $depart = Department::findOrFail($department_id);
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('th')->isoFormat('MMMM');
            $month[$i] = $monthName;
        }
        $userper = $depart->UserDe()->where('department_id', $department_id)->get();
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;

        return view('layouts.department.item.data.report.tables.t0115', compact('depart', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
}
