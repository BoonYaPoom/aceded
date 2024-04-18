<?php

namespace App\Http\Controllers\ClassRoom;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function classroom_user($department_id, $user_id)
    {

        $depart = Department::find($department_id);
        $user_data = DB::table('course_learner')
            ->join('course', 'course.course_id', '=', 'course_learner.course_id')
            ->join('course_group', 'course_group.group_id', '=', 'course.group_id')
            ->select('course.*', 'course_learner.payment_status as USER_PAYMENT')
            ->where('course_learner.learner_status', '=', 1)
            ->where('course_learner.user_id', '=', $user_id)
            ->where('course_group.department_id', '=', $department_id)
            ->get();

        $courseIds = [];
        $data_lesson = [];
        foreach ($user_data as $row) {
            $subject = $row->subject;

            if ($subject != null && $subject != "null" && $subject != "") {
                $courseIds[] = $row->course_id;
            }
        }

        if (!empty($courseIds)) {
            $result = DB::table('course_subjectlist')
                ->join('course_subject', 'course_subject.subject_id', '=', 'course_subjectlist.subject_id')
                ->join('course', 'course_subjectlist.course_id', '=', 'course.course_id')
                ->whereIn('course_subjectlist.course_id', $courseIds)
                ->select('course_subjectlist.subject_id', 'subject_th', 'banner', 'course_subjectlist.course_id', 'course.course_th')
                ->where('course_subjectlist.SUBJECT_STATUS', '=', 1)
                ->orderBy('course_subjectlist.subject_id')
                ->get();

            foreach ($result as $res) {
                $pageID =   $res->subject_id;
                $subject_th =   $res->subject_th;
                $course_th =   $res->course_th;
                $course_id =   $res->course_id;
                $banner =   $res->banner;
                $firstPart = DB::table('exam')
                    ->select(

                        DB::raw('COALESCE(
                (SELECT CASE 
                    WHEN s.fullscore IS NOT NULL THEN 1 
                    ELSE 0 
                END 
                FROM score s 
                WHERE s.exam_id = exam.exam_id 
                    AND s.user_id = ' . $user_id . ' 
                ORDER BY s.score_id DESC 
                FETCH FIRST 1 ROW ONLY
                ), 0) AS STATUS')
                    )
                    ->whereIn('exam_type', [1, 2])
                    ->where('exam_status', 1)
                    ->whereNotNull('EXAM_DATA')
                    ->where('subject_id', $pageID);
                $secondPart = DB::table('course_lesson as t1')
                    ->leftJoin('log_lesson as t2', function ($join) use ($user_id) {
                        $join->on('t1.lesson_id', '=', 't2.lesson_id')
                            ->where('t2.user_id', '=', $user_id);
                    })
                    ->leftJoin('logs as t3', function ($join) use ($user_id) {
                        $join->on('t1.lesson_id', '=', 't3.idref')
                            ->on('t2.user_id', '=', 't3.user_id')
                            ->where('t3.logid', '=', 4)
                            ->where('t3.subject_id', '=', DB::raw('t1.subject_id'));
                    })
                    ->where('t1.subject_id', $pageID)
                    ->where('t1.lesson_status', '1')
                    ->select(DB::raw('CAST(t2.status AS NUMBER) AS STATUS'));

                $emresult = $firstPart->union($secondPart)->get();


                if ($emresult->count() >= 1) {
                    $total = $emresult->count();
                    $finish = 0;
                    foreach ($emresult as $row) {
                        if ($row->status != null && $row->status > 0) {
                            $finish++;
                        }
                    }

                    $process_cal = ceil(100 / $total) * $finish;
                    if (
                        $process_cal > 100
                    ) {
                        $process_cal = 100;
                    }
                }
                $data_lesson[] = [
                    'id' => $pageID,
                    'subject' => $subject_th,
                    'process' => $process_cal,
                    'course_th' => $course_th,
                    'course_id' => $course_id,
                    'banner' => $banner
                ];
            }
        }
        //  dd(count($data_lesson));
      
        return view('layouts.department.item.data.UserAdmin.group.classroom.index', compact('depart', 'user_data', 'data_lesson'));
    }
}
