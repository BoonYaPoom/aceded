<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Models\BookCategory;
use App\Models\Department;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Imagick;
use rudrarajiv\flipbooklaravel\Flipbook;
use Spatie\PdfToImage\Pdf;


class BookController extends Controller
{
    public function bookcatpage($category_id)
    {
        $bookcat = BookCategory::findOrFail($category_id);
        $books = $bookcat->books()->where('category_id', $category_id)->get();
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.booke', compact('bookcat', 'books', 'depart'));
    }


    public function create($category_id)
    {
        $bookcat = BookCategory::findOrFail($category_id);
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.create', compact('bookcat', 'depart'));
    }

    public function store(Request $request, $category_id)
    {
        $request->validate([
            'book_name' => 'required',
            'bookfile' => 'required'
        ]);
        $bookId = $request->input('book_id');

        $books = new Book;
        $books->book_type = $request->book_type;


        $books->book_name = $request->book_name;
        $books->book_author = $request->book_author;
        $books->detail = '';
        $books->contents = $request->contents;
        $books->book_date = now();
        $books->book_status = $request->input('book_status', 0);
        $books->book_option = '';

        $books->recommended = 0;
        $books->category_id = (int) $category_id;
        $books->book_member = 0;
        $books->book_year = date('Y');
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
        // บันทึกไฟล์ PDF และแปลงเป็นรูปภาพ
        if ($request->book_type == 0) {
            if ($request->hasFile('bookfile')) {
                // บันทึกไฟล์ PDF


                $file_name = $request->file('bookfile');

                $file_namess = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                $sourceDirectory = public_path('uploads/book');

                // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                $destinationDirectory = public_path('upload/Book/' . $books->book_id);





                // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }

                // ดึงรายการไฟล์ในโฟลเดอร์ "uploads"
                $files = File::allFiles($sourceDirectory);

                // วนลูปเพื่อคัดลอกและบันทึกไฟล์ใหม่ในโฟลเดอร์ปลายทาง
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
                        $imgs = Image::make($newFolder1 . '/' . $imageFilename1);

                        // ปรับขนาดรูปภาพ
                        $imgs->resize(300, 425);


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
                    $books->bookfile = 'upload/Book/' . $books->book_id . '/' . $image_bookfile;
                    $books->save();
                }
            }
        }
        return redirect()->route('bookcatpage', ['category_id' => $category_id])->with('message', 'book สร้างเรียบร้อยแล้ว');
 
    }
    return redirect()->back()->with('error', 'ID นี้มีอยู่แล้ว กรุณาเลือก ID อื่น');
        }

    public function edit($book_id)
    {
        $books = Book::findOrFail($book_id);
        $category_id = $books->category_id;
        $bookcat = BookCategory::findOrFail($category_id);
        $department_id = $bookcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.book.bookcat.edit', ['books' => $books, 'bookcat' => $bookcat, 'depart' => $depart]);
    }
    public function update(Request $request, $book_id)
    {

        $books = Book::findOrFail($book_id);


        $books->book_name = $request->book_name;
        $books->book_author = $request->book_author;

        $books->contents = $request->contents;
        $books->book_update = now();
        $books->book_status = $request->input('book_status', 0);

        $books->book_type = $request->book_type;

        $books->book_year = date('Y');
        set_time_limit(0);
        if ($request->hasFile('cover')) {
            $image_name = 'cover' . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Book/' . $book_id);
        
            // ตรวจสอบว่าโฟลเดอร์เป้าหมายไม่มีอยู่แล้ว
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
                $oldCoverPath = public_path($books->cover);
                if (file_exists($oldCoverPath)) {
                    // ลบไฟล์ cover เดิม
                    unlink($oldCoverPath);
                }
            
            }
        
            // ตรวจสอบว่าไฟล์ cover เดิมมีอยู่หรือไม่
         
            // อัปโหลดไฟล์ cover ใหม่
            $request->cover->move($uploadDirectory, $image_name);
        
            // สร้างและบันทึกพาธใหม่ลงในโมเดล
            $books->cover = 'upload/Book/' .  $book_id . '/' . $image_name;
            $books->save();
        } 
        
        


        // บันทึกไฟล์ PDF และแปลงเป็นรูปภาพ
        if ($request->book_type == 0) {
            if ($request->hasFile('bookfile')) {
                // บันทึกไฟล์ PDF


                $file_name = $request->file('bookfile');

                $file_namess = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                $sourceDirectory = public_path('uploads/book');

                // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                $destinationDirectory = public_path('upload/Book/' .  $book_id);





                // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }

                // ดึงรายการไฟล์ในโฟลเดอร์ "uploads/book"
                $files = File::allFiles($sourceDirectory);

                // วนลูปเพื่อคัดลอกและบันทึกไฟล์ใหม่ในโฟลเดอร์ปลายทาง
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
                $file_path = public_path('upload/Book/' .  $book_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Book/' .  $book_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Book/' .  $book_id);

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
                        $imgs = Image::make($newFolder1 . '/' . $imageFilename1);

                        // ปรับขนาดรูปภาพ
                        $imgs->resize(300, 425);


                        // เซฟรูปภาพที่ปรับขนาดลงในไฟล์เดิม
                        $img->save($newFolder . '/' . $imageFilename);
                        $img->save($newFolder1 . '/' . $imageFilename1);
                        $pages[] = array(
                            'l' =>  'page/large/' . $imageFilename,
                            't' => 'page/thumb/' . $imageFilename1
                        );
                        $pageLCount = count($pages);
                        $htmlPath = public_path('upload/Book/' .  $book_id . '/index.html');
                        if (file_exists($htmlPath)) {
                            // ลบไฟล์เดิม
                            unlink($htmlPath);
                        }

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }

                    $books->bookfile =  'upload/Book/' . $book_id . '/' . 'index.html';
            
                }
            }
        } elseif ($request->book_type == 1) {
            if ($request->hasFile('bookfile')) {
                $image_bookfile = 'book' . '.' . $request->bookfile->getClientOriginalExtension();
                $uploadDirectory = public_path('upload/Book/' .   $book_id);
                $oldCoverbookfile = public_path($books->bookfile);
                if (file_exists($oldCoverbookfile)) {
                    unlink($oldCoverbookfile); // ลบไฟล์ cover เดิม
                }
                if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);

                    file_put_contents(public_path('upload/Book/' .  $book_id  . '/' . $image_bookfile), file_get_contents($request->bookfile));
                    // ลบไฟล์เดิม

                    $books->bookfile = 'upload/Book/' .  $book_id . '/' . $image_bookfile;
                }
              
            }
        }

        $books->save();


        return redirect()->route('bookcatpage', ['category_id' => $books->category_id])->with('message', 'book  เปลี่ยนแปลงเรียบร้อยแล้ว');
    }
    public function destroy($book_id)
    {
        $books = Book::findOrFail($book_id);

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
    public function changeS(Request $request)
    {
    }
}
