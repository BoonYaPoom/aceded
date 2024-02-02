<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportCController extends Controller
{
    public function ReportC()
    {
        return view('page.report2.C.index');
    }
}
