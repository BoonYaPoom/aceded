<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CourseSubject;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryac($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $catac = $subs->Catt()->where('subject_id', $subject_id)->get();
        return view('page.manage.sub.activitys.activcontent.catego.index', compact('subs', 'catac'));
    }

    public function create($subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $catac = $subs->Catt()->where('subject_id', $subject_id)->get();
        return view('page.manage.sub.activitys.activcontent.catego.create', compact('subs', 'catac'));
    }

    public function store(Request $request, $subject_id)
    {

        $catac = new Category;

        $catac->category_th = $request->category_th;
        $catac->category_en = $request->category_en;
        $catac->detail_th = $request->detail_th;
        $catac->detail_en = $request->detail_en;
        $catac->category_date = now();
        $catac->category_update = null;
        $catac->category_status = $request->input('category_status', 0);
        $catac->recommended = $request->input('recommended', 0);
        $catac->category_type = 0;
        $catac->category_option = '';

        $catac->subject_id = (int)$subject_id;
        $catac->save();


        return redirect()->route('categoryac', ['subject_id' => $subject_id])->with('message', 'Category บันทึกข้อมูลสำเร็จ');
    }
    public function edit($category_id)
    {
        $catac  = Category::findOrFail($category_id);
        return view('page.manage.sub.activitys.activcontent.catego.edit', compact('catac'));
    }
    public function update(Request $request, $category_id)
    {

        $catac  = Category::findOrFail($category_id);

        $catac->category_th = $request->category_th;
        $catac->category_en = $request->category_en;
        $catac->detail_th = $request->detail_th;
        $catac->detail_en = $request->detail_en;

        $catac->category_update = now();
        $catac->category_status = $request->input('category_status', 0);
        $catac->recommended = $request->input('recommended', 0);


        $catac->save();


        return redirect()->route('categoryac', ['subject_id' => $catac->subject_id])->with('message', 'Category บันทึกข้อมูลสำเร็จ');
    }
    public function destroy($category_id)
    {

        $catac  = Category::findOrFail($category_id);

        $catac->delete();


        return redirect()->back()->with('message', 'Category ลบสำเร็จ');
    }


    public function changeStatuCategory(Request $request)
    {
        $catac = Category::find($request->category_id);

        if ($catac) {
            $catac->category_status = $request->category_status;
            $catac->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Category']);
        }
    }
}
