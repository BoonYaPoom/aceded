<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Models\Course;
use App\Models\CourseFavorites;
use App\Models\CourseLearner;
use App\Models\Department;
use App\Models\Log;
use App\Models\PersonType;
use App\Models\Provinces;
use App\Models\Users;
use App\Models\UserSchool;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportAllController extends Controller
{
    public function Reportview()
    {


        return view('page.report.index');
    }

    public function ReportA()
    {

        $userper = Users::all();
        $count1 = Users::where('user_role', 1)->count();
        $count3 = Users::where('user_role', 3)->count();
        $count4 = Users::where('user_role', 4)->count();
        $user_role1 = Users::where('user_role', 1)->first();
        $user_role3 = Users::where('user_role', 3)->first();
        $user_role4 = Users::where('user_role', 4)->first();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();
        $learners =  CourseLearner::all();


        return view('page.report.reporta', compact('userper', 'count1', 'count3', 'count4', 'user_role1', 'user_role3', 'user_role4', 'month', 'perType', 'learners'));
    }

    public function ReportB()
    {


        $logs = Log::all();

        $userper = Users::all();
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
        $bookcat = BookCategory::all();
        return view('page.report.reportb', compact('favorit', 'bookcat', 'cour', 'userper', 'count1', 'count3', 'count4', 'month', 'perType', 'learners', 'logs'));
    }

    public function ReportC()
    {

        $userper = Users::all();


        return view('page.report.reportc', compact('userper'));
    }
    public function ReportUserAuth()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();

        $learners =  CourseLearner::all();
        return view('page.report.tables.t0101', compact('month', 'learners', 'perType', 'userper'));
    }
    public function trainUserAuth()
    {


        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0108', compact('oneYearsAgo', 'currentYear', 'month'));
    }
    public function bookUserAuth()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0103', compact('userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function LoginUserAuth()
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0104', compact('month', 'oneYearsAgo', 'currentYear'));
    }

    public function getUserData(Request $request)
    {
        $selecteduser_id = $request->input('selected_user_id');
        $userperselected = Users::where('user_id', $selecteduser_id)->get();

        return response()->json(['user_data' => $userperselected]);
    }





    public function BackUserAuth()

    {

        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        return view('page.report.tables.t0110', compact('oneYearsAgo', 'currentYear', 'month'));
    }
    public function reportMUserAuth()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0111', compact('userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function reportYeaAuth()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $year = Carbon::now()->year;
        $Quarter1 = Carbon::create($year, 1, 1);
        $Quarter2 = Carbon::create($year, 4, 1);
        $Quarter3 = Carbon::create($year, 7, 1);
        $Quarter4 = Carbon::create($year, 10, 1);
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0112', compact('userper', 'month', 'Quarter1', 'Quarter2', 'Quarter3', 'Quarter4', 'oneYearsAgo', 'currentYear'));
    }
    public function reportQuarterlyAuth()
    {

        $userper = Users::all();
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        return view('page.report.tables.t0113', compact('userper', 'currentYear', 'oneYearsAgo', 'month'));
    }
    public function BackupFullUserAuth()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        return view('page.report.tables.t0114', compact('userper', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function LogFileUserAuth()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;

        return view('page.report.tables.t0115', compact('userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }

    public function t0116()
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        $learners = CourseLearner::all();
    

    
        return view('page.report.tables.datatest.t0116', compact('learners' ,'pro', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function t0117()
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0117', compact('pro', 'month', 'oneYearsAgo', 'currentYear'));
    }
    public function t0118()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0118', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0119()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0119', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0120()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0120', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0121()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0121', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0122()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0122', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0123()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0123', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0124()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0124', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
    public function t0125()
    {
        $logs = Log::all();
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $pro = Provinces::all();
        return view('page.report.tables.datatest.t0125', compact('pro', 'userper', 'month', 'oneYearsAgo', 'currentYear', 'logs'));
    }
}
