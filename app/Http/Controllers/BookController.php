<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Models\BookCategory;
use App\Models\Department;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Imagick;

use Spatie\PdfToImage\Pdf;


class BookController extends Controller
{
    public function bookcatpage($category_id)
    {
        $bookcat  = BookCategory::findOrFail($category_id);
        $books = $bookcat->books()->where('category_id', $category_id)->get();
        $department_id   = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.booke', compact('bookcat', 'books', 'depart'));
    }


    public function create($category_id)
    {
        $bookcat  = BookCategory::findOrFail($category_id);
        $department_id   = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.create', compact('bookcat', 'depart'));
    }

    public function store(Request $request, $category_id)
    {
        $request->validate([
            'book_name' => 'required'
        ]);
        $books = new Book;
        $books->book_type = $request->book_type;
        if ($request->hasFile('cover')) {

            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('public')->put('lac/Book/' . $image_name, file_get_contents($request->cover));
            $books->cover = $image_name;
        }
        // บันทึกไฟล์ PDF และแปลงเป็นรูปภาพ
        if ($request->book_type == 0) {
            if ($request->hasFile('bookfile')) {
                // บันทึกไฟล์ PDF
                $file_name = $request->file('bookfile');
                $file_namess = $file_name->getClientOriginalName();
                $file_name->move(public_path('lac/Book'), $file_namess);

                // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                $outputPath = public_path('lac/Book');
                File::makeDirectory($outputPath, $mode = 0777, true, true);


                $pdf = new Pdf($file_namess);

                $pdf->saveAllPagesAsImages($outputPath);


                $books->bookfile = $file_namess;
            }
        } elseif ($request->book_type == 1) {
            // บันทึกไฟล์ PDF
            if ($request->hasFile('bookfile')) {
            $file_name = $request->file('bookfile');
            $file_namess = $file_name->getClientOriginalName();
            $file_name->move(public_path('lac/Book'), $file_namess);
            $books->bookfile = $file_namess;
        }
        }



        $books->book_name = $request->book_name;
        $books->book_author = $request->book_author;
        $books->detail = '';
        $books->contents = $request->contents;
        $books->book_date = now();
        $books->book_status = $request->input('book_status', 0);
        $books->book_option = '';
    
        $books->recommended = 0;
        $books->category_id = (int)$category_id;
        $books->book_member = 0;
        $books->book_year = date('Y');
        $books->save();
        return redirect()->route('bookcatpage', ['category_id' => $category_id])->with('message', 'book สร้างเรียบร้อยแล้ว');
    }

    public function edit($book_id)
    {
        $books = Book::findOrFail($book_id);
        $category_id = $books->category_id;
        $bookcat  = BookCategory::findOrFail($category_id);
        $department_id   = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.edit', ['books' => $books, 'bookcat' => $bookcat, 'depart' => $depart]);
    }
    public function update(Request $request, $book_id)
    {

        $books = Book::findOrFail($book_id);
        if ($request->hasFile('cover')) {
            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Book/image/' . $image_name, file_get_contents($request->cover));
            $books->cover = $image_name;
        }

        if ($request->hasFile('bookfile')) {

            $file_name = time() . '.' . $request->bookfile->getClientOriginalExtension();
            Storage::disk('external')->put('Book/documents/' . $file_name, file_get_contents($request->bookfile));
            $books->bookfile = $file_name;
        }

        $books->book_name = $request->book_name;
        $books->book_author = $request->book_author;

        $books->contents = $request->contents;
        $books->book_update = now();
        $books->book_status = $request->input('book_status', 0);

        $books->book_type = $request->book_type;

        $books->book_year = date('Y');
        $books->save();
        return redirect()->route('bookcatpage', ['category_id' => $books->category_id])->with('message', 'book  เปลี่ยนแปลงเรียบร้อยแล้ว');
    }
    public function destroy($book_id)
    {
        $books = Book::findOrFail($book_id);
        $image_path = public_path() . "/images/";
        $image_name = $image_path . $books->cover;
        if (file_exists($image_name)) {
            @unlink($image_name);
        }
        $image_path = public_path() . "/documents/";
        $file_name = $image_path . $books->bookfile;
        if (file_exists($file_name)) {
            @unlink($file_name);
        }
        $books->delete();
        return redirect()->route('bookcatpage', ['category_id' => $books->category_id])->with('message', 'book  ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function table(Request $request)
    {
        // Retrieve the book data
        $books = Book::all();

        return response()->json($books);
    }

    public function changeStatus(Request $request)
    {
        $books = Book::find($request->book_id);

        if ($books) {
            $books->book_status = $request->book_status;
            $books->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Book']);
        }
    }
}
