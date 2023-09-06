<?php

namespace App\Http\Controllers;

use App\Exports\QuestionExport;
use App\Exports\SubjectExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\QuestionsImportClass;
use App\Models\CourseLesson;
use App\Models\CourseSubject;
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
    public function Questionimport(Request $request, $subject_id)
    {   

        $questionsImport = new QuestionsImportClass($subject_id);

        if ($request->hasFile('fileexcel')) {
            try {
                Excel::import($questionsImport, $request->file('fileexcel'));
                return redirect()->route('questionadd', ['subject_id' => $subject_id])->with('message', 'Import successfully');
            } catch (\Exception $e) {
                return redirect()->route('questionadd', ['subject_id' => $subject_id])->with('error', 'Error importing data: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('questionadd', ['subject_id' => $subject_id])->with('error', 'No file uploaded');
        }   }
  

   

}
