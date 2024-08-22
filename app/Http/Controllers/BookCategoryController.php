<?php

namespace App\Http\Controllers;


use App\Models\BookCategory;
use App\Models\Department;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BookCategoryController extends Controller
{

    public function bookpage($department_id)
    {
        $depart = Department::findOrFail($department_id);
        $book  = $depart->BookCatDe()->where('department_id', $department_id)->get();

        return view('page.dls.book.book', compact('book', 'depart'));
    }
    public function create($department_id)
    {
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.create', compact('depart'));
    }

    public function store(Request $request, $department_id)
    {
        try {
            $request->validate([
                'category_th' => 'required',

            ]);

            $book = new BookCategory;
            $book->category_th = $request->category_th;
            $book->category_en  = $request->category_en;
            $book->detail_th = '';
            $book->detail_en = '';
            $book->category_date = now();

            $book->category_status = $request->input('category_status', 0);
            $book->category_type = 1;
            $book->category_option = null;
            $book->department_id = (int)$department_id;
            $book->recommended = 1;

            $book->save();

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
       
        }

        return redirect()->route('bookpage', ['department_id' => $book->department_id])->with('message', 'book สร้างเรียบร้อยแล้ว');
    }





    public function edit($department_id,$category_id)
    {
        $book = BookCategory::findOrFail($category_id);
        $department_id   = $book->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.edit', compact('book', 'depart'));
    }

    public function update(Request $request,$department_id, $category_id)
    {
        $request->validate([
            'category_th' => 'required',

        ]);
        $book = BookCategory::findOrFail($category_id);
        $book->category_th = $request->category_th;
        $book->category_en  = $request->category_en;
        $book->detail_th = '';
        $book->detail_en = '';
        $book->category_update = now();
        $book->category_status = 1;
        $book->category_type = 1;
        $book->category_option = '';
        $book->recommended = 1;
        $book->save();

        return redirect()->route('bookpage', ['department_id' => $book->department_id])->with('message', 'book    เปลี่ยนแปลงเรียบร้อยแล้ว');
    }
    public function destory($department_id,$category_id)
    {
        $book = BookCategory::findOrFail($category_id);

        $book->delete();
        return redirect()->back()->with('message', 'book  ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function changeStatus(Request $request)
    {
        $book = BookCategory::find($request->category_id);

        if ($book) {
            $book->category_status = $request->category_status;
            $book->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล BookCategory']);
        }
    }
}
