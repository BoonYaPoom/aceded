<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\CourseSupplymentary;
use App\Models\CourseSupplymentaryType;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseSupplymentaryController extends Controller
{
    public function supplypage($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $supplys = $subs->supplysub()->where('subject_id', $subject_id)->get();

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);

        return view('page.manage.sub.supply.index', compact('subs', 'supplys','depart'));
    }

    public function create($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
  
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.supply.create', compact('subs', 'books', 'types','depart'));
    }
    public function store(Request $request, $subject_id)
    {
    
        $validator = Validator::make($request->all(), [
            'title_th' => 'required',
            'title_en' => 'required',
            // เพิ่มรายการตรวจสอบข้อมูลที่ต้องการตรวจสอบ
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        $supplys = new CourseSupplymentary;


        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->type;
 
        if ($request->hasFile('path')) {
            $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/Supplys/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/Supplys/' . $image_name), file_get_contents($request->path));
                $supplys->path = 'upload/Subject/Supplys/' . 'path' . '.' . $request->path->getClientOriginalExtension();
           
            }
        }

 
        $supplys->subject_id = (int)$subject_id;
        $supplys->lesson_id = 0;

        $supplys->save();

        return redirect()->route('supplypage', ['subject_id' => $subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function edit($supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
        $subject_id =  $supplys->subject_id;
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.supply.edit', compact('supplys', 'types', 'books','depart'));
    }
    public function update(Request $request, $supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);

        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->type;
   
        if ($request->hasFile('path')) {
            $image_name = 'path' .  $supplys->supplymentary_id . '.' . $request->path->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/Supplys/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/Supplys/' . $image_name), file_get_contents($request->path));
                $supplys->path = 'upload/Subject/Supplys/' . 'path'.  $supplys->supplymentary_id . '.' . $request->path->getClientOriginalExtension();
            }
        } else {
            $image_name = '';
            $supplys->path = $image_name;
        }



        $supplys->save();

        return redirect()->route('supplypage', ['subject_id' => $supplys->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
    public function destroy($supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);
        $supplys->delete();
        return redirect()->route('supplypage', ['subject_id' => $supplys->subject_id])->with('message', 'Course_lesson ลบข้อมูลสำเร็จ');
    }

    public function changeStatus(Request $request)
    {
        $supplys = CourseSupplymentary::find($request->supplymentary_id);

        if ($supplys) {
            $supplys->supplymentary_status = $request->supplymentary_status;
            $supplys->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Supply']);
        }
    }
    public function supplyLess($subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lesson = CourseLesson::findOrFail($lesson_id);
        $supplys = $lesson->supplyLesson()->where('lesson_id', $lesson_id)->get();
 
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.supply.index', compact('lesson', 'supplys', 'subs', 'lessonsSub','depart'));
    }

    public function createLess($subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lesson = CourseLesson::findOrFail($lesson_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.supply.create', compact('lesson', 'books', 'types', 'subs', 'lessonsSub','depart'));
    }

    public function storeLess(Request $request, $subject_id, $lesson_id)
    {

        $request->validate([

            'supplymentary_type' => 'required',

        ]);
        $supplys = new CourseSupplymentary;


        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->supplymentary_type;
       
        if ($request->hasFile('path')) {
            $image_name = 'path' . $lesson_id . '.' . $request->path->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/Lesson/Supplymentary/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/Lesson/Supplymentary/' . $image_name), file_get_contents($request->path));
                $supplys->path = 'upload/Subject/Lesson/Supplymentary/' . 'path'  . $lesson_id . '.' . $request->path->getClientOriginalExtension();
            }
        } else {
      
            $supplys->path = $request->cover;
        }
        $supplys->cover_image = $request->cover;
       
        $supplys->lesson_id = (int)$lesson_id;
        $supplys->subject_id = (int)$subject_id;

        $supplys->save();

        return redirect()->route('Supply_lessonform', ['subject_id' => $subject_id, 'lesson_id' => $lesson_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
    public function editLess($supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
        $subject_id =  $supplys->subject_id;
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.supply.edit', compact('supplys', 'types', 'books','depart'));
    }

    public function updateLess(Request $request, $supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);

        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->type;

        if ($request->hasFile('path')) {
            $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Subject/Supplys/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Subject/Supplys/' . $image_name), file_get_contents($request->path));
                $supplys->path = 'upload/Subject/Supplys/' . 'path' . '.' . $request->path->getClientOriginalExtension();
               
            }
        } 

        $supplys->save();

        return redirect()->route('Supply_lessonform', ['subject_id' => $supplys->subject_id , 'lesson_id' => $supplys->lesson_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
}
