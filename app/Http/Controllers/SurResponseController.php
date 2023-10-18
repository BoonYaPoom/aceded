<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurResponseController extends Controller
{
    public function resPonse($department_id,$survey_id){
        $sur = Survey::findOrFail($survey_id);
        $surques = $sur->surs()->where('survey_id',$survey_id)->get();

        return view('page.manages.survey.surveyquestion.surveexem',compact('sur','surques')); 

    }
  
}
