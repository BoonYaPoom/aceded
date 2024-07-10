<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CourseLesson;
use App\Models\CourseSubject;
use App\Models\CourseSupplymentary;
use App\Models\CourseSupplymentaryType;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class CourseSupplymentaryController extends Controller
{
    public function supplypage($department_id,$subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $supplys = $subs->supplysub()->where('subject_id', $subject_id)->get();

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);

        return view('page.manage.sub.supply.index', compact('subs', 'supplys', 'depart'));
    }

    public function create($department_id,$subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $types = CourseSupplymentaryType::all();

        $depart = Department::findOrFail($department_id);
        $bookcats  = $depart->BookCatDe()->where('department_id', $department_id)->get();

 
        return view('page.manage.sub.supply.create', compact('subs', 'bookcats', 'types', 'depart'));
    }
    public function store(Request $request,$department_id, $subject_id)
    {

        $validator = Validator::make($request->all(), [
            'title_th' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try {
            $supplys = new CourseSupplymentary;
            $supplys->supplymentary_type = $request->type;

            $supplys->title_th = $request->title_th;
            $supplys->title_en = $request->title_en;
            $supplys->cover_image = $request->cover;
            $supplys->author = $request->author;
            $supplys->supplymentary_status = $request->input('supplymentary_status', 0);

            if ($supplys->supplymentary_type == 3) {
                if ($request->hasFile('path')) {
                    $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
                    // $uploadDirectory = public_path('upload/Subject/Supplys/');
                    // if (!file_exists($uploadDirectory)) {
                    //     mkdir($uploadDirectory, 0755, true);
                    // }
                    // if (file_exists($uploadDirectory)) {

                    //     file_put_contents(public_path('upload/Subject/Supplys/' . $image_name), file_get_contents($request->path));
                    //     $supplys->path = 'upload/Subject/Supplys/' . 'path' . '.' . $request->path->getClientOriginalExtension();
                    // }
                    $uploadDirectory = 'Subject/Supplys/' . $subject_id;
                    if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                        Storage::disk('sftp')->makeDirectory($uploadDirectory);
                    }
                    if (Storage::disk('sftp')->exists($uploadDirectory)) {
                        // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                        Storage::disk('sftp')->delete($uploadDirectory);
                        Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->path->getRealPath()));
                        $supplys->path = 'upload/Subject/Supplys/' . $subject_id . 'path' . '.' . $request->path->getClientOriginalExtension();
                        $supplys->save();
                    }
                    
                }
               
            }


            if ($supplys->supplymentary_type == 5) {
                $supplys->cover_image = $request->cover;
                $supplys->path = $request->cover;
            }

            $supplys->subject_id = (int)$subject_id;
            $supplys->lesson_id = 0;

            $supplys->save();
            set_time_limit(0);
            ini_set('max_execution_time', 300);
            ini_set('pcre.backtrack_limit', 5000000);
            if ($supplys->supplymentary_type == 2) {
                if ($request->hasFile('path')) {
                 // บันทึกไฟล์ PDF
                    $file_name = $request->file('path');
                    $file_namess = 'Supplys' . '.' . $request->path->getClientOriginalExtension();
                    // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                    $sourceDirectory = public_path('upload/Subject/Supplys/');

                    // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                    $destinationDirectory = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);
                    // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                    if (!File::exists($destinationDirectory)) {
                        File::makeDirectory($destinationDirectory, 0777, true, true);
                    }
                    // ดึงรายการไฟล์ในโฟลเดอร์ "uploads/Supplys"
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
                    $file_path = public_path('upload/Subject/Supplys/' .  $supplys->supplymentary_id) . '/' . $file_namess;
                    $file_name->move(public_path('upload/Subject/Supplys/' .   $supplys->supplymentary_id), $file_namess);

                    // Check if the PDF file exists
                    if (file_exists($file_path)) {
                        // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                        $outputPath = public_path('upload/Subject/Supplys/' .   $supplys->supplymentary_id);

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
                            $htmlPath = public_path('upload/Subject/Supplys/' .  $supplys->supplymentary_id . '/index.html');
                            if (file_exists($htmlPath)) {
                                // ลบไฟล์เดิม
                                unlink($htmlPath);
                            }

                            $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                            file_put_contents($htmlPath, $htmlContent);
                        }

                        $supplys->path =  'upload/Subject/Supplys/' .  $supplys->supplymentary_id . '/' . 'index.html';
                        $supplys->save();
                    }

                    $localPath = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);

                    if (file_exists($localPath)) {
                        $files = File::allFiles($localPath);
                        foreach ($files as $file) {
                            // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                            $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);
                            // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                            $newDirectoryPath = 'Subject/Supplys/' . $supplys->supplymentary_id . '/' . $originalDirectoryName;
                            if (!Storage::disk('sftp')->exists($newDirectoryPath)) {
                                Storage::disk('sftp')->makeDirectory($newDirectoryPath, 0777, true, true);
                            }

                            // คัดลอกและบันทึกไฟล์ใหม่
                            $newFileName = $file->getFilename();
                            $fileContents = File::get($file->getPathname());
                            Storage::disk('sftp')->put($newDirectoryPath . '/' . $newFileName, $fileContents);
                        }
                        // ลบโฟลเดอร์ใน local path
                        File::deleteDirectory($localPath);
                    }
 
                }

            }
            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->view('error.error-500', [], 500);
        }
        return redirect()->route('supplypage', [$department_id,'subject_id' => $subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function edit($department_id,$subject_id,$supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
        $subject_id =  $supplys->subject_id;
        $subs = CourseSubject::findOrFail($subject_id);
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        $bookcats  = $depart->BookCatDe()->where('department_id', $department_id)->get();
        return view('page.manage.sub.supply.edit', compact('supplys','subs', 'types', 'bookcats', 'depart'));
    }
    public function update(Request $request,$department_id,$subject_id, $supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);

        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->supplymentary_type;

        if ($supplys->supplymentary_type == 3) {
            if ($request->hasFile('path')) {
                $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Subject/Supplys/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/Subject/Supplys/' . $image_name), file_get_contents($request->path));
                //     $supplys->path = 'upload/Subject/Supplys/' . 'path' . '.' . $request->path->getClientOriginalExtension();
                // }
                $uploadDirectory = 'Subject/Supplys/' . $subject_id;
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->path->getRealPath()));
                    $supplys->path = 'upload/Subject/Supplys/' . $subject_id . 'path' . '.' . $request->path->getClientOriginalExtension();
                    $supplys->save();
                }
            }
        }


        if ($supplys->supplymentary_type == 5) {
            $supplys->cover_image = $request->cover;
            $supplys->path = $request->cover;
        }
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);
        if ($supplys->supplymentary_type == 2) {
            if ($request->hasFile('path')) {
             // บันทึกไฟล์ PDF
                $file_name = $request->file('path');
                $file_namess = 'Supplys' . '.' . $request->path->getClientOriginalExtension();
                // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                $sourceDirectory = public_path('upload/Subject/Supplys/');

                // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                $destinationDirectory = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);
                // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }
                // ดึงรายการไฟล์ในโฟลเดอร์ "uploads/Supplys"
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
                $file_path = public_path('upload/Subject/Supplys/' .  $supplys->supplymentary_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Subject/Supplys/' .   $supplys->supplymentary_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Subject/Supplys/' .   $supplys->supplymentary_id);

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
                        $htmlPath = public_path('upload/Subject/Supplys/' .  $supplys->supplymentary_id . '/index.html');
                        if (file_exists($htmlPath)) {
                            // ลบไฟล์เดิม
                            unlink($htmlPath);
                        }

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }

                    $supplys->path =  'upload/Subject/Supplys/' .  $supplys->supplymentary_id . '/' . 'index.html';
                    $supplys->save();
            
                    $localPath = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);
                    if (file_exists($localPath)) {
                        $files = File::allFiles($localPath);
                        foreach ($files as $file) {
                            // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                            $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);
                            // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                            $newDirectoryPath = 'Subject/Supplys/' . $supplys->supplymentary_id . '/' . $originalDirectoryName;
                            if (!Storage::disk('sftp')->exists($newDirectoryPath)) {
                                Storage::disk('sftp')->makeDirectory($newDirectoryPath, 0777, true, true);
                            }

                            // คัดลอกและบันทึกไฟล์ใหม่
                            $newFileName = $file->getFilename();
                            $fileContents = File::get($file->getPathname());
                            Storage::disk('sftp')->put($newDirectoryPath . '/' . $newFileName, $fileContents);
                        }
                        // ลบโฟลเดอร์ใน local path
                        File::deleteDirectory($localPath);
                    }
                }
            }

        }

        $supplys->save();

        return redirect()->route('supplypage', [$department_id,$subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
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
    public function supplyLess($department_id,$subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lesson = CourseLesson::findOrFail($lesson_id);
        $supplys = $lesson->supplyLesson()->where('lesson_id', $lesson_id)->get();

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.supply.index', compact('lesson', 'supplys', 'subs', 'lessonsSub', 'depart'));
    }

    public function createLess($department_id,$subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lesson = CourseLesson::findOrFail($lesson_id);
        $types = CourseSupplymentaryType::all();
        $books = Book::all();
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        $bookcats  = $depart->BookCatDe()->where('department_id', $department_id)->get();
        return view('page.manage.sub.lesson.supply.create', compact('lesson', 'bookcats', 'types', 'subs', 'lessonsSub', 'depart'));
    }

    public function storeLess(Request $request,$department_id, $subject_id, $lesson_id)
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
        $supplys->cover_image = $request->cover;

        $supplys->lesson_id = (int)$lesson_id;
        $supplys->subject_id = $subject_id;


        if ($supplys->supplymentary_type == 3) {
            if ($request->hasFile('path')) {
                $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Subject/Lesson/Supplymentary/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/Subject/Lesson/Supplymentary/' . $image_name), file_get_contents($request->path));
                //     $supplys->path = 'upload/Subject/Lesson/Supplymentary/' . 'path' . '.' . $request->path->getClientOriginalExtension();
                // }
                $uploadDirectory = 'Subject/Supplys/' . $subject_id;
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->path->getRealPath()));
                    $supplys->path = 'upload/Subject/Supplys/' . $subject_id . 'path' . '.' . $request->path->getClientOriginalExtension();
                    $supplys->save();
                }
            }
        }


        if ($supplys->supplymentary_type == 5) {
            $supplys->cover_image = $request->cover;
            $supplys->path = $request->cover;
        }
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);
        if ($supplys->supplymentary_type == 2) {
            if ($request->hasFile('path')) {
             // บันทึกไฟล์ PDF
                $file_name = $request->file('path');
                $file_namess = 'Supplys' . '.' . $request->path->getClientOriginalExtension();
                // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                $sourceDirectory = public_path('upload/Subject/Lesson/Supplymentary/');

                // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                $destinationDirectory = public_path('upload/Subject/Lesson/Supplymentary/' . $supplys->supplymentary_id);
                // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }
                // ดึงรายการไฟล์ในโฟลเดอร์ "uploads/Supplys"
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
                $file_path = public_path('upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Subject/Lesson/Supplymentary/' .   $supplys->supplymentary_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Subject/Lesson/Supplymentary/' .   $supplys->supplymentary_id);

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
                        $htmlPath = public_path('upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id . '/index.html');
                        if (file_exists($htmlPath)) {
                            // ลบไฟล์เดิม
                            unlink($htmlPath);
                        }

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }

                    $supplys->path =  'upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id . '/' . 'index.html';
                    $supplys->save();
                }
                $localPath = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);

                if (file_exists($localPath)) {
                    $files = File::allFiles($localPath);
                    foreach ($files as $file) {
                        // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                        $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);
                        // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                        $newDirectoryPath = 'Subject/Supplys/' . $supplys->supplymentary_id . '/' . $originalDirectoryName;
                        if (!Storage::disk('sftp')->exists($newDirectoryPath)) {
                            Storage::disk('sftp')->makeDirectory($newDirectoryPath, 0777, true, true);
                        }

                        // คัดลอกและบันทึกไฟล์ใหม่
                        $newFileName = $file->getFilename();
                        $fileContents = File::get($file->getPathname());
                        Storage::disk('sftp')->put($newDirectoryPath . '/' . $newFileName, $fileContents);
                    }
                    // ลบโฟลเดอร์ใน local path
                    File::deleteDirectory($localPath);
                }
            }

        }


        $supplys->save();

        return redirect()->route('Supply_lessonform', [$department_id,'subject_id' => $subject_id, 'lesson_id' => $lesson_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
    public function editLess($department_id,$subject_id,$lesson_id,$supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);
        $types = CourseSupplymentaryType::all();
        $subs  = CourseSubject::findOrFail($subject_id);
        $lesson = CourseLesson::findOrFail($lesson_id);
        $depart = Department::findOrFail($department_id);
        $books = Book::all();
        $bookcats  = $depart->BookCatDe()->where('department_id', $department_id)->get();
        return view('page.manage.sub.lesson.supply.edit', compact('supplys', 'types', 'lesson','bookcats', 'depart','subs'));
    }

    public function updateLess(Request $request,$department_id,$subject_id,$lesson_id,$supplymentary_id)
    {
        $supplys  = CourseSupplymentary::findOrFail($supplymentary_id);

        $supplys->title_th = $request->title_th;
        $supplys->title_en = $request->title_en;
        $supplys->cover_image = $request->cover;
        $supplys->author = $request->author;
        $supplys->supplymentary_status = $request->input('supplymentary_status', 0);
        $supplys->supplymentary_type = $request->supplymentary_type;



        if ($supplys->supplymentary_type == 3) {
            if ($request->hasFile('path')) {
                $image_name = 'path' . '.' . $request->path->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/Subject/Lesson/Supplymentary/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/Subject/Lesson/Supplymentary/' . $image_name), file_get_contents($request->path));
                //     $supplys->path = 'upload/Subject/Lesson/Supplymentary/' . 'path' . '.' . $request->path->getClientOriginalExtension();
                // }
                $uploadDirectory = 'Subject/Supplys/' . $subject_id;
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $image_name, file_get_contents($request->path->getRealPath()));
                    $supplys->path = 'upload/Subject/Supplys/' . $subject_id . 'path' . '.' . $request->path->getClientOriginalExtension();
                    $supplys->save();
                }
            }
        }


        if ($supplys->supplymentary_type == 5) {
            $supplys->cover_image = $request->cover;
            $supplys->path = $request->cover;
        }
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);
        if ($supplys->supplymentary_type == 2) {
            if ($request->hasFile('path')) {
             // บันทึกไฟล์ PDF
                $file_name = $request->file('path');
                $file_namess = 'Supplys' . '.' . $request->path->getClientOriginalExtension();
                // ระบุโฟลเดอร์ที่ต้องการดึงข้อมูล
                // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ ถ้าไม่มีให้สร้างขึ้น
                $sourceDirectory = public_path('upload/Subject/Lesson/Supplymentary/');

                // ระบุโฟลเดอร์ที่ต้องการบันทึกข้อมูลใหม่
                $destinationDirectory = public_path('upload/Subject/Lesson/Supplymentary/' . $supplys->supplymentary_id);
                // สร้างโพลเดอร์ปลายทางหากยังไม่มี
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0777, true, true);
                }
                // ดึงรายการไฟล์ในโฟลเดอร์ "uploads/Supplys"
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
                $file_path = public_path('upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id) . '/' . $file_namess;
                $file_name->move(public_path('upload/Subject/Lesson/Supplymentary/' .   $supplys->supplymentary_id), $file_namess);

                // Check if the PDF file exists
                if (file_exists($file_path)) {
                    // สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
                    $outputPath = public_path('upload/Subject/Lesson/Supplymentary/' .   $supplys->supplymentary_id);

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
                        $htmlPath = public_path('upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id . '/index.html');
                        if (file_exists($htmlPath)) {
                            // ลบไฟล์เดิม
                            unlink($htmlPath);
                        }

                        $htmlContent = view('flipbook.flipbook', ['pages' => $pages, 'pageLCount' => $pageLCount])->render();
                        file_put_contents($htmlPath, $htmlContent);
                    }

                    $supplys->path =  'upload/Subject/Lesson/Supplymentary/' .  $supplys->supplymentary_id . '/' . 'index.html';
                    $supplys->save();
                }
                $localPath = public_path('upload/Subject/Supplys/' . $supplys->supplymentary_id);

                if (file_exists($localPath)) {
                    $files = File::allFiles($localPath);
                    foreach ($files as $file) {
                        // หาชื่อโฟลเดอร์เดิมที่อยู่ในชื่อไฟล์
                        $originalDirectoryName = pathinfo($file->getRelativePathname(), PATHINFO_DIRNAME);
                        // สร้างโฟลเดอร์ปลายทางในกรณีที่ยังไม่มี
                        $newDirectoryPath = 'Subject/Supplys/' . $supplys->supplymentary_id . '/' . $originalDirectoryName;
                        if (!Storage::disk('sftp')->exists($newDirectoryPath)) {
                            Storage::disk('sftp')->makeDirectory($newDirectoryPath, 0777, true, true);
                        }

                        // คัดลอกและบันทึกไฟล์ใหม่
                        $newFileName = $file->getFilename();
                        $fileContents = File::get($file->getPathname());
                        Storage::disk('sftp')->put($newDirectoryPath . '/' . $newFileName, $fileContents);
                    }
                    // ลบโฟลเดอร์ใน local path
                    File::deleteDirectory($localPath);
                }
            }

        }

        $supplys->save();

        return redirect()->route('Supply_lessonform', [$department_id,$subject_id,$lesson_id,$supplymentary_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
}
