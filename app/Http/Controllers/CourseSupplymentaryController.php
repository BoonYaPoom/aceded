<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CourseSubject;
use App\Models\CourseSupplymentary;
use App\Models\CourseSupplymentaryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseSupplymentaryController extends Controller
{
    public function supplypage($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $supplys = $subs->supplysub()->where('subject_id', $subject_id)->get();


        return view('page.manage.sub.supply.index', compact('subs', 'supplys'));
    }

    public function create($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
        return view('page.manage.sub.supply.create', compact('subs', 'books', 'types'));
    }
    public function store(Request $request, $subject_id)
    {
        $request->validate([

            'supplymentary_type' => 'required',
            
        ]);
        $supplys = new CourseSupplymentary;


        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->type;
        if ($request->hasFile('path')) {

            $image_name = time() . '.' . $request->path->getClientOriginalExtension();
            Storage::disk('external')->put('Subject/Supplymentary/path/' . $image_name, file_get_contents($request->path));
        } else {
            $image_name = '';
        }
        $supplys->path = $image_name;
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
        return view('page.manage.sub.supply.edit', compact('supplys', 'types', 'books'));
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
            $image_name = time() . '.' . $request->path->getClientOriginalExtension();
            Storage::disk('external')->put('Subject/Supplymentary/path/' . $image_name, file_get_contents($request->path));
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
            return response()->json(['message' => 'ไม่พบข้อมูล Blog']);
        }
    }
}
