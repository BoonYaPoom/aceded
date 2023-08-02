<?php

namespace App\Http\Controllers;

use App\Exports\QuestionExport;
use App\Exports\SubjectExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\QuestionsImportClass;
use App\Models\Question;

class ExcelController extends Controller
{
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'Administrator Management Users.xlsx');
    }
    public function exportSubject()
    {
        return Excel::download(new SubjectExport, 'Administrator Management System.xlsx');
    }
    public function questionExport()
    {
        return Excel::download(new QuestionExport, 'Question System.xlsx');
    }
    public function Questionimport(Request $request)
    {

    
        Excel::import(new QuestionsImportClass, $request->file('fileexcel'));
        return redirect()->back()->with('message','Import Success successfully');
        // Import successful
        // You can redirect or return a response here
    }
    
}
  

