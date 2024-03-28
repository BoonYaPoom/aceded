<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Models\BookCategory;
use App\Models\Department;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Imagick;
use rudrarajiv\flipbooklaravel\Flipbook;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class BookController extends Controller
{
    public function bookcatpage($department_id, $category_id)
    {
        $bookcat = BookCategory::findOrFail($category_id);
        $books = $bookcat->books()->where('category_id', $category_id)->get();
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.booke', compact('bookcat', 'books', 'depart'));
    }


    public function create($department_id, $category_id)
    {
        $bookcat = BookCategory::findOrFail($category_id);
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.create', compact('bookcat', 'depart'));
    }

    public function store(Request $request, $department_id, $category_id)
    {
        $request->validate([
            'book_name' => 'required',
            'bookfile' => 'required'
        ]);
        $books = new Book;
        $books->book_type = $request->book_type;
        $books->book_name = $request->book_name;

        if ($request->book_author) {
            $books->book_author = $request->book_author;
        } else {
            $books->book_author = 'สำนักงาน ปปช.';
        }
        $books->detail = '';

        $books->book_date = now();
        $books->book_status = $request->input('book_status', 0);
        $books->book_option = '';

        $books->recommended = $request->input('recommended', 0);
        $books->category_id = (int) $category_id;
        $books->book_member = 0;
        $books->book_year = date('Y');


        if (!file_exists(public_path('/upload/Book/ck/'))) {
            mkdir(public_path('/upload/Book/ck/'), 0755, true);
        }

        if ($request->has('contents')) {
            $contents = $request->contents;
            $decodedText = '';
            if (!empty($contents)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // Set encoding to UTF-8
                $contents = mb_convert_encoding($contents, 'HTML-ENTITIES', 'UTF-8');
                libxml_use_internal_errors(true); // Enable internal error handling
                $contents = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $contents);
                $de_th->loadHTML($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors(); // Clear any accumulated errors
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Book/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $contents = $de_th->saveHTML();
                $decodedText = html_entity_decode($contents, ENT_QUOTES, 'UTF-8');
            }

            $books->contents = $decodedText;
        }
        $books->save();


        if ($request->hasFile('cover')) {
            $image_name = 'cover' . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Book/' . $books->book_id);
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {
                file_put_contents(public_path('upload/Book/' . $books->book_id . '/' . $image_name), file_get_contents($request->cover));
                // สร้างและบันทึกชื่อ cover ลงในโมเดล
                $books->cover = 'upload/Book/' . $books->book_id . '/' . 'cover' . '.' . $request->cover->getClientOriginalExtension();
                $books->save();
            }
        } else {
            $image_name = '';
            $books->cover = $image_name;
            $books->save();
        }


        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);


        if ($request->hasFile('bookfile')) {
            // บันทึกไฟล์ PDF และแปลงเป็นรูปภาพ
            if ($request->book_type == 0) {
                $file_name = $request->file('bookfile');
                $file_namess = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                $sourceDirectory = public_path('uploads/book');
                $destinationDirectory = public_path('upload/Book/' . $books->book_id);
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }
                $files = File::allFiles($sourceDirectory);
                foreach ($files as $file) {
                    // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                    $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);

                    // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                    $newDirectoryPath = $destinationDirectory . '/' . $originalDirectoryName;
                    if (!File::exists($newDirectoryPath)) {
                        File::makeDirectory($newDirectoryPath, 0777, true, true);
                    }

                    // คัดลอกและบันทึกไฟล์ใหม่
                    $newFileName = $file->getFilename();
                    $fileContents = File::get($file->getPathname());
                    File::put($newDirectoryPath . '/' . $newFileName, $fileContents);
                }
                $file_path = public_path('upload/Book/' . $books->book_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Book/' . $books->book_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Book/' . $books->book_id);

                    // Construct the folder name based on the count
                    $folderName = 'page';


                    $newFolder = $outputPath . '/' . $folderName . '/large';
                    File::makeDirectory($newFolder, $mode = 0777, true, true);
                    $newFolder1 = $outputPath . '/' . $folderName . '/thumb';
                    File::makeDirectory($newFolder1, $mode = 0777, true, true);

                    $pdf = new Pdf($file_path);

                    $pages = array();
                    $pagesCount = $pdf->getNumberOfPages();

                    for ($page = 1; $page <= $pagesCount; $page++) {
                        $imageFilename = "book-{$page}.png";
                        $imageFilename1 = "book-thumb-{$page}.png";

                        $pdf->setPage($page)->saveImage($newFolder . '/' . $imageFilename);
                        $pdf->setPage($page)->saveImage($newFolder1 . '/' . $imageFilename1);

                        // โหลดรูปภาพ
                        $img = Image::make($newFolder . '/' . $imageFilename);

                        // ปรับขนาดรูปภาพ
                        $img->resize(600, 849);


                        // เซฟรูปภาพที่ปรับขนาดลงในไฟล์เดิม
                        $img->save($newFolder . '/' . $imageFilename);
                        $img->save($newFolder1 . '/' . $imageFilename1);
                        $pages[] = array(
                            'l' =>  'page/large/' . $imageFilename,
                            't' => 'page/thumb/' . $imageFilename1
                        );

                        $pageLCount = count($pages);
                        $htmlPath = public_path('upload/Book/' . $books->book_id . '/index.html');

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }
                    $books->bookfile =  'upload/Book/' . $books->book_id . '/' . 'index.html';
                    $books->save();
                }
            } elseif ($request->book_type == 1) {
                if ($request->hasFile('bookfile')) {
                    $image_bookfile = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                    $uploadDirectory = public_path('upload/Book/' . $books->book_id);
                    if (!file_exists($uploadDirectory)) {
                        mkdir($uploadDirectory, 0755, true);
                    }
                    if (file_exists($uploadDirectory)) {

                        file_put_contents(public_path('upload/Book/' . $books->book_id  . '/' . $image_bookfile), file_get_contents($request->bookfile));
                    }
                    $books->bookfile = 'upload/Book/' . $books->book_id . '/' . $image_bookfile;
                    $books->save();
                }
            }
        }

        return redirect()->route('bookcatpage', [$department_id, 'category_id' => $category_id])->with('message', 'book สร้างเรียบร้อยแล้ว');
    }

    public function edit($department_id, $book_id)
    {
        $books = Book::findOrFail($book_id);
        $category_id = $books->category_id;
        $bookcat = BookCategory::findOrFail($category_id);
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.edit', ['books' => $books, 'bookcat' => $bookcat, 'depart' => $depart]);
    }
    public function update(Request $request, $department_id, $book_id)
    {

        $books = Book::findOrFail($book_id);
        $books->book_name = $request->book_name;
        $books->recommended = $request->input('recommended', 0);
        if ($request->book_author) {
            $books->book_author = $request->book_author;
        } 
        
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/upload/Book/ck/'))) {
            mkdir(public_path('/upload/Book/ck/'), 0755, true);
        }


        if ($request->has('contents')) {
            $contents = $request->contents;
            $decodedText = '';
            if (!empty($contents)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8';
                $contents = mb_convert_encoding($contents, 'HTML-ENTITIES', 'UTF-8');
                libxml_use_internal_errors(true);
                $contents = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $contents);
                $de_th->loadHTML($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors();
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Book/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }

                $contents = $de_th->saveHTML();
                $decodedText = html_entity_decode($contents, ENT_QUOTES, 'UTF-8');
            }

            $books->contents = $decodedText;
        }
        $books->book_update = now();
        $books->book_status = $request->input('book_status', 0);

        $books->book_type = $request->book_type;

        $books->book_year = date('Y');
        set_time_limit(0);
        if ($request->hasFile('cover')) {
            $image_name = 'cover' . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Book/' . $books->book_id);
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {
                file_put_contents(public_path('upload/Book/' . $books->book_id . '/' . $image_name), file_get_contents($request->cover));
                // สร้างและบันทึกชื่อ cover ลงในโมเดล
                $books->cover = 'upload/Book/' . $books->book_id . '/' . 'cover' . '.' . $request->cover->getClientOriginalExtension();
            }
        }

        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);
        ini_set('fastcgi_read_timeout', 400);

        // บันทึกไฟล์ PDF และแปลงเป็นรูปภาพ
        if ($request->hasFile('bookfile')) {
            if ($request->book_type == 0) {
                $file_name = $request->file('bookfile');
                $file_namess = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                $sourceDirectory = public_path('uploads/book');
                $destinationDirectory = public_path('upload/Book/' . $books->book_id);
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }
                $files = File::allFiles($sourceDirectory);
                foreach ($files as $file) {
                    // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                    $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);

                    // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                    $newDirectoryPath = $destinationDirectory . '/' . $originalDirectoryName;
                    if (!File::exists($newDirectoryPath)) {
                        File::makeDirectory($newDirectoryPath, 0777, true, true);
                    }

                    // คัดลอกและบันทึกไฟล์ใหม่
                    $newFileName = $file->getFilename();
                    $fileContents = File::get($file->getPathname());
                    File::put($newDirectoryPath . '/' . $newFileName, $fileContents);
                }
                $file_path = public_path('upload/Book/' . $books->book_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Book/' . $books->book_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Book/' . $books->book_id);

                    // Construct the folder name based on the count
                    $folderName = 'page';


                    $newFolder = $outputPath . '/' . $folderName . '/large';
                    File::makeDirectory($newFolder, $mode = 0777, true, true);
                    $newFolder1 = $outputPath . '/' . $folderName . '/thumb';
                    File::makeDirectory($newFolder1, $mode = 0777, true, true);

                    $pdf = new Pdf($file_path);

                    $pages = array();
                    $pagesCount = $pdf->getNumberOfPages();

                    for ($page = 1; $page <= $pagesCount; $page++) {
                        $imageFilename = "book-{$page}.png";
                        $imageFilename1 = "book-thumb-{$page}.png";

                        $pdf->setPage($page)->saveImage($newFolder . '/' . $imageFilename);
                        $pdf->setPage($page)->saveImage($newFolder1 . '/' . $imageFilename1);

                        // โหลดรูปภาพ
                        $img = Image::make($newFolder . '/' . $imageFilename);

                        // ปรับขนาดรูปภาพ
                        $img->resize(600, 849);



                        // เซฟรูปภาพที่ปรับขนาดลงในไฟล์เดิม
                        $img->save($newFolder . '/' . $imageFilename);
                        $img->save($newFolder1 . '/' . $imageFilename1);
                        $pages[] = array(
                            'l' =>  'page/large/' . $imageFilename,
                            't' => 'page/thumb/' . $imageFilename1
                        );

                        $pageLCount = count($pages);
                        $htmlPath = public_path('upload/Book/' . $books->book_id . '/index.html');

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }
                    $books->bookfile =  'upload/Book/' . $books->book_id . '/' . 'index.html';
                }
            } elseif ($request->book_type == 1) {
                if ($request->hasFile('bookfile')) {
                    $image_bookfile = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                    $uploadDirectory = public_path('upload/Book/' . $books->book_id);

                    if (!file_exists($uploadDirectory)) {
                        mkdir($uploadDirectory, 0755, true);
                    }

                    if (file_exists($uploadDirectory)) {

                        file_put_contents(public_path('upload/Book/' . $books->book_id  . '/' . $image_bookfile), file_get_contents($request->bookfile));
                    }
                    $books->bookfile = 'upload/Book/' . $books->book_id . '/' . $image_bookfile;
                }
            }
        }
        $books->save();

        return redirect()->route('bookcatpage', [$department_id, 'category_id' => $books->category_id])->with('message', 'book  เปลี่ยนแปลงเรียบร้อยแล้ว');
    }
    public function destroy($book_id)
    {
        $books = Book::findOrFail($book_id);

        $books->delete();
        return redirect()->back()->with('message', 'book  ลบข้อมูลเรียบร้อยแล้ว');
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
    public function changeS(Request $request)
    {
    }
}
