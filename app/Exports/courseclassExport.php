<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\CourseGroup;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;

class courseclassExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $cour = Course::findOrFail($course_id);

        $learners =  $cour->learnCouse()->where('course_id', $course_id)->get();
        $group_id = $cour->group_id;
        $courses = CourseGroup::findOrFail($group_id);
        $department_id = $courses->department_id;
        $depart= Department::find($department_id); 

        foreach ($learners as $learns){
        $dataLearn = $learns->registerdate;
        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
        $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
        $users = \App\Models\Users::find($learns->user_id);
        
        if ($users !== null) {
            $ScoreLog = \App\Models\Score::where('user_id', $learns->user_id)
                ->whereHas('examlog', function ($query) {
                    $query->where('exam_type', 2);
                })
                ->get();
        } else {
  
            $ScoreLog = NULL;
         
        }
    }
        if ($users !== null)    {
        if ($monthsa == $m){
            if (!in_array($learns->user_id, $uniqueUserIds)){
               
                    array_push($uniqueUserIds, $learns->user_id);
                    
                    $countUsersLogs = \App\Models\Log::where('user_id', $users->user_id)
                        ->where('logid', 4)
                        ->count();
                    $totalDuration = \App\Models\Log::where('user_id', $users->user_id)
                        ->where('logid', 4)
                        ->sum('duration');
                    $ScoreUser = \App\Models\Score::where('user_id', $users->user_id)
                        ->whereHas('examlog', function ($query) {
                            $query->where('exam_type', 2);
                        })
                        ->latest('score_date')
                        ->get();
                    
                    $totalDurationInMinutes = $totalDuration / 60;
                    
                    $totalHours = floor($totalDurationInMinutes / 60); // จำนวนชั่วโมง
                    $totalMinutes = $totalDurationInMinutes % 60; // จำนวนนาทีที่เหลือ
                    
                    if ($totalMinutes > 60) {
                        $totalHours += floor($totalMinutes / 60);
                        $totalMinutes %= 60;
                    }
                    $latestScore = null;
                    $latfullScore = null;
                    $latestScorelog = null;
                    $latfullScorelog = null;
                    $percentage = 0;
                    
                    $percentagelog = 0;
                    
                    }
                }
            }
                foreach ($ScoreUser as $score){
               
                        
                        if ($score->score && $score->fullscore) {
                            if (($latestScore === null && $latfullScore === null) || $score->score_date > $latestScoreDate) {
                                $latestScore = $score->score;
                                $latfullScore = $score->fullscore;
                                $latestScoreDate = $score->score_date;
                        
                                if ($latfullScore) {
                                    $percentage = ($latestScore / $latfullScore) * 100;
                                }
                            }
                        }
                        $ScoreDatelog = [];
             
                }


        $data->push([
            'Column1' => $n++,
            'Column2' => $users->username,
            'Column3' => $users->firstname . ' ' . $users->lastname,
            'Column4' => $countUsersLogs,
            'Column5' => $totalHours . ' ชั่วโมง ' . number_format($totalMinutes) . ' นาที',
            'Column6' => $latestScore ? $latestScore : 'ยังไม่ให้คะแนน',
            'Column7' => $percentage > 50 ? 'ผ่าน' : 'ไม่ผ่าน',
        ]);
        return ;
    }
}
