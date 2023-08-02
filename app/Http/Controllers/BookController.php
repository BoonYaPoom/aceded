<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function bookcatpage($category_id)
    {
        $bookcat  = BookCategory::findOrFail($category_id);
        $books = $bookcat->books()->where('category_id', $category_id)->get();
        return view('page.dls.book.bookcat.booke', compact('bookcat', 'books'));
    }


    public function create($category_id)
    {
        $bookcat  = BookCategory::findOrFail($category_id);
        return view('page.dls.book.bookcat.create', compact('bookcat'));
    }

    public function store(Request $request, $category_id)
    {
        $request->validate([
            'book_name' => 'required'
        ]);
        $books = new Book;
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
        $books->detail = '';
        $books->contents = $request->contents;
        $books->book_date = now();
        $books->book_status = $request->input('book_status', 0);
        $books->book_option = '';
        $books->book_type = $request->book_type;
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
        return view('page.dls.book.bookcat.edit', ['books' => $books]);
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
        $books = Book::all(); // Fetch all books from the database

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
