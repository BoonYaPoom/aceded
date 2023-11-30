<?php

namespace App\Http\Controllers;


use App\Models\ContentType;
use App\Models\CourseLesson;
use ZipArchive;


use App\Models\CourseSubject;
use App\Models\Department;
use DOMDocument;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseLessonController extends Controller
{
    public function navless($department_id,$subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessons = $subs->subjs()->where('subject_id', $subject_id)->get();
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.navsubject', compact('subs', 'lessons', 'depart'));
    }
    public function lessonpage($department_id,$subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessons = $subs->subjs()->where('subject_id', $subject_id)->get();
        $uploadSuccess = true; // หรือ false ตามเงื่อนไขของคุณ

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.lesson', compact('subs', 'lessons', 'depart'), [

            'uploadSuccess' => $uploadSuccess,
        ]);
    }

    public function create($department_id,$subject_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);
        $department_id =  $subs->department_id;
        $count1 = ContentType::all()->count();

        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.create', compact('subs', 'content_types', 'depart'));
    }

    public function store(Request $request,$department_id, $subject_id)
    {

        $validator = Validator::make($request->all(), [


            'lesson_th' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try {
            $lessons = new CourseLesson;
            $lessons->lesson_number = $request->lesson_number;
            $lessons->lesson_th = $request->lesson_th;
            $lessons->lesson_en = $request->lesson_en;
            $lessons->description = '';

            set_time_limit(0);
       
            if (!file_exists(public_path('/uplade/lesson'))) {
                mkdir(public_path('/uplade/lesson'), 0755, true);
            }
    
        
            if ($request->has('resultlesson')) {
                $resultlesson = $request->resultlesson;
                $decodedTextresultlesson = '';
                if (!empty($resultlesson)) {
                    $des_th = new DOMDocument();
                    $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $resultlesson = mb_convert_encoding($resultlesson, 'HTML-ENTITIES', 'UTF-8');
                    $resultlesson = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $resultlesson);
                    $des_th->loadHTML($resultlesson, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                        libxml_use_internal_errors(true);
                    $images_des_th = $des_th->getElementsByTagName('img');
    
                    foreach ($images_des_th as $key => $img) {
                        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                            $image_name = '/uplade/lesson/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                            file_put_contents(public_path() . $image_name, $data);
                            $img->removeAttribute('src');
                            $newImageUrl = asset($image_name);
                            $img->setAttribute('src', $newImageUrl);
                        }
                    }
                    $resultlesson = $des_th->saveHTML();
                    $decodedTextresultlesson = html_entity_decode($resultlesson, ENT_QUOTES, 'UTF-8');
                }
    
                $lessons->resultlesson = $decodedTextresultlesson;
            }
            $lessons->content_type = $request->content_type;
            $lessons->lesson_status = $request->input('lesson_status', 0);
            $lessons->exercise = $request->input('exercise', 0);
            $lessons->subject_id = (int)$subject_id;
            $lessons->lesson_id_ref = 0;

            $lessons->content_path = '';
            $lessons->ordering = null;
            $lessons->permission = null;


            $lessons->save();
            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->view('error.error-500', [], 500);
        }
        return redirect()->route('lessonpage', [$department_id,'subject_id' => $subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function edit($department_id,$subject_id,$lesson_id)
    {


        $lessons = CourseLesson::findOrFail($lesson_id);
        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);

        $subs = CourseSubject::findOrFail($subject_id);

        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.edit', compact('lessons', 'content_types', 'subs', 'depart'));
    }
    public function update(Request $request,$department_id, $lesson_id)
    {

        $lessons = CourseLesson::findOrFail($lesson_id);
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        set_time_limit(0);
        
            if (!file_exists(public_path('/uplade/lesson'))) {
                mkdir(public_path('/uplade/lesson'), 0755, true);
            }
    
        
            if ($request->has('resultlesson')) {
                $resultlesson = $request->resultlesson;
                $decodedTextresultlesson = '';
                if (!empty($resultlesson)) {
                    $des_th = new DOMDocument();
                    $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $resultlesson = mb_convert_encoding($resultlesson, 'HTML-ENTITIES', 'UTF-8');
                    $resultlesson = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $resultlesson);
                    $des_th->loadHTML($resultlesson, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                        libxml_use_internal_errors(true);
                    $images_des_th = $des_th->getElementsByTagName('img');
    
                    foreach ($images_des_th as $key => $img) {
                        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                            $image_name = '/uplade/lesson/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                            file_put_contents(public_path() . $image_name, $data);
                            $img->removeAttribute('src');
                            $newImageUrl = asset($image_name);
                            $img->setAttribute('src', $newImageUrl);
                        }
                    }

                    $resultlesson = $des_th->saveHTML();
                    $decodedTextresultlesson = html_entity_decode($resultlesson, ENT_QUOTES, 'UTF-8');
                }
    
                $lessons->resultlesson = $decodedTextresultlesson;
            }
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = $request->input('lesson_status', 0);
        $lessons->exercise = $request->input('exercise', 0);


        $lessons->save();

        return redirect()->route('lessonpage', [$department_id,'subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }

    public function destroy($department_id,$lesson_id)
    {
        $lessons = CourseLesson::findOrFail($lesson_id);

        $lessons->delete();
        return redirect()->route('lessonpage', [$department_id,'subject_id' => $lessons->subject_id])->with('message', 'Course_lesson ลบข้อมูลสำเร็จ');
    }





    public function uploadfile(Request $request,$department_id, $lesson_id)
    {
        $lessons = CourseLesson::findOrFail($lesson_id);
        $content_type = $lessons->content_type;
        if ($request->hasFile('content_path')) {
            $uploadedFile = $request->file('content_path');

            $image_name = time() . '.' . $uploadedFile->getClientOriginalExtension();
            if ($content_type == 9) {
                // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ zip

                if ($uploadedFile->getClientOriginalExtension() == 'zip') {
                    $directory = 'upload/Subject/Lesson/alld/Html/';

                    $folderName = 'lesson_' .  $lesson_id;

                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้าง
                    $destinationFolder = public_path($directory . $folderName);
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0755, true);
                    }
                    // ย้ายไฟล์ zip ไปยังโฟลเดอร์ปลายทาง



                    $uploadedFile->move($destinationFolder, $uploadedFile->getClientOriginalName());
                    $zipFilePath = $destinationFolder . '/' . $uploadedFile->getClientOriginalName();
                    // ตรวจสอบว่าไฟล์ zip ถูกเปิดเรียบร้อย
                    $zip = new ZipArchive;

                    // เปิดไฟล์ ZIP
                    if ($zip->open($zipFilePath) === TRUE) {
                        // ตรวจสอบว่าไฟล์ ZIP ถูกเปิดเรียบร้อย
                        // กำหนดโฟลเดอร์ปลายทางสำหรับการแตกไฟล์
                        $extractPath = $destinationFolder;

                        // สร้างโฟลเดอร์ปลายทางหากยังไม่มี
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0755, true);
                        }

                        // แตกไฟล์ ZIP ไปยังโฟลเดอร์ปลายทาง
                        $zip->extractTo($extractPath);

                        // ปิดไฟล์ ZIP
                        $zip->close();
                    }

                    $lessons->content_path = 'upload/Subject/Lesson/alld/Html/' . $folderName;
                }
            } elseif ($content_type == 10) {
                // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ zip

                if ($uploadedFile->getClientOriginalExtension() == 'zip') {
                    $directory = 'upload/Subject/Lesson/alld/AICC/';

                    $folderName = 'lesson_' .  $lesson_id;

                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้าง
                    $destinationFolder = public_path($directory . $folderName);
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0755, true);
                    }
                    // ย้ายไฟล์ zip ไปยังโฟลเดอร์ปลายทาง



                    $uploadedFile->move($destinationFolder, $uploadedFile->getClientOriginalName());
                    $zipFilePath = $destinationFolder . '/' . $uploadedFile->getClientOriginalName();
                    // ตรวจสอบว่าไฟล์ zip ถูกเปิดเรียบร้อย
                    $zip = new ZipArchive;

                    // เปิดไฟล์ ZIP
                    if ($zip->open($zipFilePath) === TRUE) {
                        // ตรวจสอบว่าไฟล์ ZIP ถูกเปิดเรียบร้อย
                        // กำหนดโฟลเดอร์ปลายทางสำหรับการแตกไฟล์
                        $extractPath = $destinationFolder;

                        // สร้างโฟลเดอร์ปลายทางหากยังไม่มี
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0755, true);
                        }

                        // แตกไฟล์ ZIP ไปยังโฟลเดอร์ปลายทาง
                        $zip->extractTo($extractPath);

                        // ปิดไฟล์ ZIP
                        $zip->close();
                    }

                    $lessons->content_path = 'upload/Subject/Lesson/alld/AICC/' . $folderName;
                }
            } elseif ($content_type == 11) {
                // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ zip

                if ($uploadedFile->getClientOriginalExtension() == 'zip') {
                    $directory = 'upload/Subject/Lesson/alld/Scorm1.2/';

                    $folderName = 'lesson_' .  $lesson_id;

                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้าง
                    $destinationFolder = public_path($directory . $folderName);
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0755, true);
                    }
                    // ย้ายไฟล์ zip ไปยังโฟลเดอร์ปลายทาง



                    $uploadedFile->move($destinationFolder, $uploadedFile->getClientOriginalName());
                    $zipFilePath = $destinationFolder . '/' . $uploadedFile->getClientOriginalName();
                    // ตรวจสอบว่าไฟล์ zip ถูกเปิดเรียบร้อย
                    $zip = new ZipArchive;

                    // เปิดไฟล์ ZIP
                    if ($zip->open($zipFilePath) === TRUE) {
                        // ตรวจสอบว่าไฟล์ ZIP ถูกเปิดเรียบร้อย
                        // กำหนดโฟลเดอร์ปลายทางสำหรับการแตกไฟล์
                        $extractPath = $destinationFolder;

                        // สร้างโฟลเดอร์ปลายทางหากยังไม่มี
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0755, true);
                        }

                        // แตกไฟล์ ZIP ไปยังโฟลเดอร์ปลายทาง
                        $zip->extractTo($extractPath);

                        // ปิดไฟล์ ZIP
                        $zip->close();
                    }

                    $lessons->content_path = 'upload/Subject/Lesson/alld/Scorm1.2/' . $folderName;
                }
            } elseif ($content_type == 12) {
                // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ zip

                if ($uploadedFile->getClientOriginalExtension() == 'zip') {
                    $directory = 'upload/Subject/Lesson/alld/Scorm2004/';

                    $folderName = 'lesson_' .  $lesson_id;

                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้าง
                    $destinationFolder = public_path($directory . $folderName);
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0755, true);
                    }
                    // ย้ายไฟล์ zip ไปยังโฟลเดอร์ปลายทาง



                    $uploadedFile->move($destinationFolder, $uploadedFile->getClientOriginalName());
                    $zipFilePath = $destinationFolder . '/' . $uploadedFile->getClientOriginalName();
                    // ตรวจสอบว่าไฟล์ zip ถูกเปิดเรียบร้อย
                    $zip = new ZipArchive;

                    // เปิดไฟล์ ZIP
                    if ($zip->open($zipFilePath) === TRUE) {
                        // ตรวจสอบว่าไฟล์ ZIP ถูกเปิดเรียบร้อย
                        // กำหนดโฟลเดอร์ปลายทางสำหรับการแตกไฟล์
                        $extractPath = $destinationFolder;

                        // สร้างโฟลเดอร์ปลายทางหากยังไม่มี
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0755, true);
                        }

                        // แตกไฟล์ ZIP ไปยังโฟลเดอร์ปลายทาง
                        $zip->extractTo($extractPath);

                        // ปิดไฟล์ ZIP
                        $zip->close();
                    }

                    $lessons->content_path = 'upload/Subject/Lesson/alld/Scorm2004/' . $folderName;
                }
            } elseif ($content_type == 13) {
                // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นไฟล์ zip

                if ($uploadedFile->getClientOriginalExtension() == 'zip') {
                    $directory = 'upload/Subject/Lesson/alld/xAPI/';

                    $folderName = 'lesson_' .  $lesson_id;

                    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีอยู่หรือไม่ หากไม่มีให้สร้าง
                    $destinationFolder = public_path($directory . $folderName);
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0755, true);
                    }
                    // ย้ายไฟล์ zip ไปยังโฟลเดอร์ปลายทาง



                    $uploadedFile->move($destinationFolder, $uploadedFile->getClientOriginalName());
                    $zipFilePath = $destinationFolder . '/' . $uploadedFile->getClientOriginalName();
                    // ตรวจสอบว่าไฟล์ zip ถูกเปิดเรียบร้อย
                    $zip = new ZipArchive;

                    // เปิดไฟล์ ZIP
                    if ($zip->open($zipFilePath) === TRUE) {
                        // ตรวจสอบว่าไฟล์ ZIP ถูกเปิดเรียบร้อย
                        // กำหนดโฟลเดอร์ปลายทางสำหรับการแตกไฟล์
                        $extractPath = $destinationFolder;

                        // สร้างโฟลเดอร์ปลายทางหากยังไม่มี
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0755, true);
                        }

                        // แตกไฟล์ ZIP ไปยังโฟลเดอร์ปลายทาง
                        $zip->extractTo($extractPath);

                        // ปิดไฟล์ ZIP
                        $zip->close();
                    }

                    $lessons->content_path = 'upload/Subject/Lesson/alld/xAPI/' . $folderName;
                }
            } else {

                // บันทึกไฟล์ใน public_path โดยใช้ public_path()
                file_put_contents(public_path('upload/Subject/Lesson/alld/' . $image_name), file_get_contents($request->content_path));

                $lessons->content_path =  'upload/Subject/Lesson/alld/' . $image_name;
            }
        }

        $lessons->save(); // เพิ่มบรรทัดนี้เพื่อบันทึกข้อมูล


        // ถ้าไม่มีเงื่อนไขหรือไม่ตรงกับเงื่อนไขใดเลย จะเด้งกลับไปที่หน้า lessonpage
        return redirect()->route('lessonpage', [$department_id,'subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }


    public function smallcreate($department_id,$subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lessons = CourseLesson::findOrFail($lesson_id);

        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.small.createsmall', compact('lessons', 'content_types', 'lessonsSub', 'subs', 'depart'));
    }
    public function smallsmallcreate($department_id,$subject_id, $lesson_id)
    {
        $subs  = CourseSubject::findOrFail($subject_id);
        $lessonsSub = $subs->subjs()->where('subject_id', $subject_id)->get();
        $lessons = CourseLesson::findOrFail($lesson_id);

        $content_types = ContentType::where('status', 1)->get(['content_type', 'content_th']);

        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.lesson.small.createsmallsmall', compact('lessons', 'content_types', 'lessonsSub', 'subs', 'depart'));
    }

    public function smailstore(Request $request,$department_id, $subject_id, $lesson_id)
    {
        $lessons = new CourseLesson;
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        $lessons->description = '';
        set_time_limit(0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/uplade/lesson'))) {
            mkdir(public_path('/uplade/lesson'), 0755, true);
        }

    
        if ($request->has('resultlesson')) {
            $resultlesson = $request->resultlesson;
            $decodedTextresultlesson = '';
            if (!empty($resultlesson)) {
                $des_th = new DOMDocument();
                $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $resultlesson = mb_convert_encoding($resultlesson, 'HTML-ENTITIES', 'UTF-8');
                $resultlesson = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $resultlesson);
                $des_th->loadHTML($resultlesson, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_des_th = $des_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/uplade/lesson/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $resultlesson = $des_th->saveHTML();
                $decodedTextresultlesson = html_entity_decode($resultlesson, ENT_QUOTES, 'UTF-8');
            }

            $lessons->resultlesson = $decodedTextresultlesson;
        }
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = 2;
        $lessons->exercise = $request->input('exercise', 0);
        $lessons->subject_id = (int)$subject_id;
        $lessons->lesson_id_ref = (int)$lesson_id;
        $lessons->content_path = '';

        $existingSubLessons = CourseLesson::where('lesson_id_ref', $lesson_id)->get();
        if ($existingSubLessons->isEmpty()) {
            // ถ้าไม่มีข้อมูลย่อยในฐานข้อมูลที่มี ref_id เท่ากับ lesson_id ที่ถูกส่งมา
            // ให้กำหนด ordering เริ่มต้นเป็น 1
            $lessons->ordering = 1;
        } else {
            // ถ้ามีข้อมูลย่อยในฐานข้อมูลที่มี ref_id เท่ากับ lesson_id ที่ถูกส่งมา
            // ให้หาค่า ordering สูงสุดและเพิ่มขึ้นอีก 1
            $maxOrdering = $existingSubLessons->max('ordering');
            $lessons->ordering = $maxOrdering + 1;
        }

        $lessons->permission = null;
        $lessons->save();

        return redirect()->route('lessonpage', [$department_id,'subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
    }
    public function smailsmailstore(Request $request, $department_id,$subject_id, $lesson_id)
    {
        $lesson = CourseLesson::findOrFail($lesson_id);
        $lessons = new CourseLesson;
        $lessons->lesson_number = $request->lesson_number;
        $lessons->lesson_th = $request->lesson_th;
        $lessons->lesson_en = $request->lesson_en;
        $lessons->description = '';
        set_time_limit(0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/uplade/lesson'))) {
            mkdir(public_path('/uplade/lesson'), 0755, true);
        }

    
        if ($request->has('resultlesson')) {
            $resultlesson = $request->resultlesson;
            $decodedTextresultlesson = '';
            if (!empty($resultlesson)) {
                $des_th = new DOMDocument();
                $des_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $resultlesson = mb_convert_encoding($resultlesson, 'HTML-ENTITIES', 'UTF-8');
                $resultlesson = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $resultlesson);
                $des_th->loadHTML($resultlesson, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_des_th = $des_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/uplade/lesson/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $resultlesson = $des_th->saveHTML();
                $decodedTextresultlesson = html_entity_decode($resultlesson, ENT_QUOTES, 'UTF-8');
            }

            $lessons->resultlesson = $decodedTextresultlesson;
        }
        $lessons->content_type = $request->content_type;
        $lessons->lesson_status = 2;
        $lessons->exercise = $request->input('exercise', 0);
        $lessons->subject_id = (int)$subject_id;
        $lessons->lesson_id_ref = (int)$lesson_id;

        $lessons->content_path = '';
        $lessons->ordering = $lesson->ordering;
        $lessons->permission = null;
        $lessons->save();

        return redirect()->route('lessonpage', [$department_id,'subject_id' => $lessons->subject_id])->with('message', 'Course_lesson บันทึกข้อมูลสำเร็จ');
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
