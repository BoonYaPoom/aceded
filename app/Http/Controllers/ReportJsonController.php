<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CourseLearner;
use App\Models\Log;
use App\Models\Provinces;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportJsonController extends Controller
{


    public function t0103()
    {

        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $currentYear = Carbon::now()->addYears(543)->year;
        $oneYearsAgo = Carbon::now()->subYears(1)->addYears(543)->year;
        $logid = Log::all();
        $logbookall = [];
        $l = 1;
        foreach ($logid as $lo => $logs) {
            $logsC = $logs->logid;
            if ($logsC == 10) {

                $Bookname = Book::where('book_id', $logs->idref)
                    ->pluck('book_name')
                    ->first();
                $BookCount = Book::where('book_id', $logs->idref)->count();

                $logbookall[] = [
                    'num' => $l++,
                    'bookname' => $Bookname,
                    'bookcount' => $BookCount,
                ];
            }
        }
        return response()->json(['book' => $logbookall]);
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
    
        
        return response()->json([]);
    }
}
