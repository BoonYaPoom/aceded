<?php

namespace App\Http\Controllers;


use App\Models\ContentType;
use App\Models\CourseLesson;


use App\Models\CourseSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseLessonController extends Controller
{
    public function navless($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessons = $subs->subjs()->where('subject_id', $subject_id)->get();
        return view('page.manage.sub.navsubject', compact('subs', 'lessons'));
    }
    public function lessonpage($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessons = $subs->subjs()->where('subject_id', $subject_id)->get();
        $uploadSuccess = true; // หรือ false ตามเงื่อนไขของคุณ


        return view('page.manage.sub.lesson.lesson', compact('subs', 'lessons'), [

            'uploadSuccess' => $uploadSuccess,
        ]);
    }

    public function create($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);
        return view('page.manage.sub.lesson.create', compact('subs', 'content_types'));
    }

    public function store(Request $request, $subject_id)
    {

        $lessons = new CourseLesson;
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        $lessons->description = '';
        $lessons->resultlesson = $request->resultlesson;
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = $request->input('lesson_status', 0);
        $lessons->exercise = $request->input('exercise', 0);
        $lessons->subject_id = (int)$subject_id;
        $lessons->lesson_id_ref = 0;

        $lessons->content_path = '';
        $lessons->ordering = null;
        $lessons->permission = null;


        $lessons->save();

        return redirect()->route('lessonpage', ['subject_id' => $subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function edit($lesson_id)
    {

        $lessons = CourseLesson::findOrFail($lesson_id);
        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);
        return view('page.manage.sub.lesson.edit', compact('lessons', 'content_types'));
    }
    public function update(Request $request, $lesson_id)
    {

        $lessons = CourseLesson::findOrFail($lesson_id);
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        $lessons->resultlesson = $request->resultlesson;
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = $request->input('lesson_status', 0);
        $lessons->exercise = $request->input('exercise', 0);


        $lessons->save();

        return redirect()->route('lessonpage', ['subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function destroy($lesson_id)
    {
        $lessons = CourseLesson::findOrFail($lesson_id);

        $lessons->delete();
        return redirect()->route('lessonpage', ['subject_id' => $lessons->subject_id])->with('message', 'Course_lesson ลบข้อมูลสำเร็จ');
    }





    public function uploadfile(Request $request, $lesson_id)
    {
        $lessons = CourseLesson::findOrFail($lesson_id);
        if ($request->hasFile('content_path')) {
            // ลบไฟล์เดิม (ถ้ามี)
            //if ($lessons->content_path && file_exists(public_path('alld/' . $lessons->content_path))) {
             //   unlink(public_path('alld/' . $lessons->content_path));
           // }
  
            $image_name = time() . '.' . $request->content_path->getClientOriginalExtension();
            Storage::disk('external')->put('Subject/Lesson/alld/' . $image_name, file_get_contents($request->content_path));
            $lessons->content_path = $image_name;
        }
        $lessons->save(); // เพิ่มบรรทัดนี้เพื่อบันทึกข้อมูล


        // ถ้าไม่มีเงื่อนไขหรือไม่ตรงกับเงื่อนไขใดเลย จะเด้งกลับไปที่หน้า lessonpage
        return redirect()->route('lessonpage', ['subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }


    public function smallcreate($subject_id,$lesson_id )
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lessons = CourseLesson::findOrFail($lesson_id);
      
        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);
       
        return view('page.manage.sub.lesson.small.createsmall', compact('lessons', 'content_types', 'lessonsSub', 'subs'));
    }

    public function smailstore(Request $request, $subject_id, $lesson_id)
    {
        $lessons = new CourseLesson;
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        $lessons->description = '';
        $lessons->resultlesson = $request->resultlesson;
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = $request->input('lesson_status', 0);
        $lessons->exercise = $request->input('exercise', 0);
        $lessons->subject_id = (int)$subject_id;
        $lessons->lesson_id_ref = (int)$lesson_id;

        $lessons->content_path = '';
        $lessons->ordering = 1;
        $lessons->permission = null;


        $lessons->save();

        return redirect()->route('lessonpage', ['subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }



    public function changeStatus(Request $request)
    {
        $lessons = CourseLesson::find($request->lesson_id);

        if ($lessons) {
            $lessons->lesson_status = $request->lesson_status;
            $lessons->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Blog']);
        }
    }
}
