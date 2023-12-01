<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\CourseSubject;
use App\Models\Department;
use App\Models\Survey;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
class SurveyController extends Controller
{
   public function surveypage($department_id)
   {
      $depart = Department::findOrFail($department_id);
      $sur  = $depart->SurDe()->where('department_id', $department_id)->get();

      return view('page.manages.survey.index', compact('sur', 'depart'));
   }
   public function create($department_id)
   {
      $depart = Department::findOrFail($department_id);
      return view('page.manages.survey.create', compact('depart'));
   }
   public function store(Request $request, $department_id)
   {
      $depart = Department::findOrFail($department_id);
      $request->validate([
         'survey_th' => 'required',
         'detail_th' => 'required'
      ]);



      $sur = new Survey;
      $sur->survey_th = $request->survey_th;
      $sur->survey_en = 0;
      
      if (!file_exists(public_path('/upload/suy/ck/'))) {
         mkdir(public_path('/upload/suy/ck/'), 0755, true);
      }
      if ($request->has('detail_th')) {
         $detail_th = $request->detail_th;
         $decodedTextdetail_th ='' ;
         if (!empty($detail_th)) {
            $de_th = new DOMDocument();
            $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
        
            $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors(true);
            $images_des_th = $de_th->getElementsByTagName('img');

            foreach ($images_des_th as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_th = $de_th->saveHTML();
            $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
         }

         $sur->detail_th = $decodedTextdetail_th;
      }
      $sur->detail_en = null;
      $sur->survey_date = now();


      $sur->survey_status = $request->input('survey_status', 0);
      $sur->survey_lang = $request->survey_lang;
      $sur->survey_type = 0;
      $sur->recommended = null;
      $sur->class_id = null;
      $sur->department_id = (int)$department_id;
      $saveSuccess = $sur->save();

      $dataqr = QrCode::size(512)
      ->format('png')
      ->merge(public_path('/LOGO/logo.png'), 0.5, true) 
      ->errorCorrection('Q')
      ->generate(url('https://aced-lb.nacc.go.th/' . $depart->name_short_en . '/survey/assessment/' . $sur->survey_id));


      $filename =  $request->survey_id . '.png';
      $uploadDirectory = public_path('upload/suy/qr/');
      
      if (!File::exists($uploadDirectory)) {
          mkdir($uploadDirectory, 0755, true);
      }
      
      if (File::exists($uploadDirectory)) {
         file_put_contents(public_path('upload/suy/qr/' . $filename), $dataqr);
         $sur->cover = 'upload/suy/qr/' . $filename;
          $sur->save();
      }

      if ($saveSuccess) {
         return redirect()->route('surveypage', ['department_id' => $sur->department_id])->with('message', 'Survey บันทึกข้อมูลสำเร็จ');
      } else {
         // กรณีที่บันทึกไม่สำเร็จ
         return redirect()->back()->with('error', 'ไม่สามารถบันทึก Survey ได้');
      }
   }

   public function edit($department_id, $survey_id)
   {
      $sur = Survey::findOrFail($survey_id);

      $depart = Department::findOrFail($department_id);
      return view('page.manages.survey.edit', ['sur' => $sur, 'depart' => $depart]);
   }

   public function update(Request $request, $department_id, $survey_id)
   {
      $depart = Department::findOrFail($department_id);
      $request->validate([
         'survey_th' => 'required',
  
      ]);
      $sur = Survey::findOrFail($survey_id);
      $sur->survey_th = $request->survey_th;
      $sur->survey_en = $request->survey_th;
  
      if (!file_exists(public_path('/upload/suy/ck/'))) {
         mkdir(public_path('/upload/suy/ck/'), 0755, true);
      }
      if ($request->has('detail_th')) {
         $detail_th = $request->detail_th;
         $decodedTextdetail_th ='' ;
         if (!empty($detail_th)) {
            $de_th = new DOMDocument();
            $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
       
            $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
               libxml_use_internal_errors(true);
            $images_des_th = $de_th->getElementsByTagName('img');

            foreach ($images_des_th as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_th = $de_th->saveHTML();
            $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
         }

         $sur->detail_th = $decodedTextdetail_th;
      }
      $sur->detail_en = null;
      $sur->survey_date = now();
      $sur->survey_lang = $request->survey_lang;
      $sur->recommended = null;
      $sur->class_id = null;
    
      $sur->save();


      
      $dataqr = QrCode::size(512)
      ->format('png')
      ->merge(public_path('/LOGO/logo.png'), 0.5, true) 
      ->errorCorrection('Q')
      ->generate(url('https://aced-lb.nacc.go.th/' . $depart->name_short_en . '/survey/assessment/' . $sur->survey_id));


      $filename =  $request->survey_id . '.png';
      $uploadDirectory = public_path('upload/suy/qr/');
      
      if (!File::exists($uploadDirectory)) {
          mkdir($uploadDirectory, 0755, true);
      }
      
      if (File::exists($uploadDirectory)) {
         file_put_contents(public_path('upload/suy/qr/' . $filename), $dataqr);
         $sur->cover = 'upload/suy/qr/' . $filename;
          $sur->save();
      }

      return redirect()->route('surveypage', ['department_id' => $sur->department_id])->with('message', 'Survey บันทึกข้อมูลสำเร็จ');
   }
   public function destory($survey_id)
   {
      $sur = Survey::findOrFail($survey_id);
      $sur->surs()->delete();
      $sur->delete();
      return redirect()->back()->with('message', 'Survey ลบข้อมูลสำเร็จ');
   }




   public function surveyact($department_id, $subject_id)
   {
      $subs  = CourseSubject::findOrFail($subject_id);
      $suracts = $subs->suyvs()->where('subject_id', $subject_id)->get();

      $depart = Department::findOrFail($department_id);

      return view('page.manage.sub.activitys.activcontent.survey.index', compact('subs', 'suracts', 'depart'));
   }

   public function suycreate($department_id, $subject_id)
   {
      $subs  = CourseSubject::findOrFail($subject_id);


      $depart = Department::findOrFail($department_id);
      return view('page.manage.sub.activitys.activcontent.survey.create', compact('subs', 'depart'));
   }

   public function storesuySupject(Request $request, $department_id, $subject_id)
   {
      $depart = Department::findOrFail($department_id);
     
     
      $request->validate([
         'survey_th' => 'required',
         'detail_th' => 'required'
      ]);
      $sur = new Survey;
      $sur->survey_th = $request->survey_th;
      $sur->survey_en = $request->survey_en;
      
      if (!file_exists(public_path('/upload/suy/Dp/ck/'))) {
         mkdir(public_path('/upload/suy/Dp/ck/'), 0755, true);
      }
      if ($request->has('detail_th')) {
         $detail_th = $request->detail_th;
         $decodedTextdetail_th ='' ;
         if (!empty($detail_th)) {
            $de_th = new DOMDocument();
            $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
            $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);
            $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
               libxml_use_internal_errors(true);
            $images_des_th = $de_th->getElementsByTagName('img');

            foreach ($images_des_th as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_th = $de_th->saveHTML();
            $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
         }

         $sur->detail_th = $decodedTextdetail_th;
      }
      if ($request->has('detail_en')) {
         $detail_en = $request->detail_en;
         $decodedTextdetail_en ='' ;
         if (!empty($detail_en)) {
            $de_e = new DOMDocument();
            $de_e->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
            $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
            $de_e->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
               libxml_use_internal_errors(true);
            $images_de_e = $de_e->getElementsByTagName('img');

            foreach ($images_de_e as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_en = $de_e->saveHTML();
            $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
         }

         $sur->detail_en = $decodedTextdetail_en;
      }

      $sur->survey_date = now();

      $sur->survey_status = $request->input('survey_status', 0);
      $sur->survey_type = 0;
      $sur->recommended = $request->input('recommended', 0);
      $sur->class_id = null;
      $sur->cover = null;
      $sur->subject_id = (int)$subject_id;
      $sur->save();


      return redirect()->route('surveyact', ['department_id' => $sur->department_id, 'subject_id' => $subject_id])->with('message', 'Survey บันทึกข้อมูลสำเร็จ');
   }

   public function suyedit($department_id, $survey_id)
   {
      $suruy  = Survey::findOrFail($survey_id);
      $subject_id = $suruy->subject_id;
      $subs  = CourseSubject::findOrFail($subject_id);
      $suracts = $subs->suyvs()->where('subject_id', $subject_id)->get();


      $depart = Department::findOrFail($department_id);
      return view('page.manage.sub.activitys.activcontent.survey.edit', compact('suruy', 'subs', 'depart'));
   }
   public function Updatesuy(Request $request, $department_id, $survey_id)
   {
      $suruy  = Survey::findOrFail($survey_id);
      $suruy->survey_th = $request->survey_th;
      $suruy->survey_en = $request->survey_en;
     
      if (!file_exists(public_path('/upload/suy/Dp/ck/'))) {
         mkdir(public_path('/upload/suy/Dp/ck/'), 0755, true);
      }
      if ($request->has('detail_th')) {
         $detail_th = $request->detail_th;
         $decodedTextdetail_th ='' ;
         if (!empty($detail_th)) {
            $de_th = new DOMDocument();
            $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_th = mb_convert_encoding($detail_th, 'HTML-ENTITIES', 'UTF-8');
            $detail_th = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_th);
            $de_th->loadHTML($detail_th, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
      
            libxml_use_internal_errors(true);
            $images_des_th = $de_th->getElementsByTagName('img');

            foreach ($images_des_th as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_th = $de_th->saveHTML();
            $decodedTextdetail_th = html_entity_decode($detail_th, ENT_QUOTES, 'UTF-8');
         }


         $suruy->detail_th = $decodedTextdetail_th;
      }
      if ($request->has('detail_en')) {
         $detail_en = $request->detail_en;
         $decodedTextdetail_en ='' ;
         if (!empty($detail_en)) {
            $de_e = new DOMDocument();
            $de_e->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $detail_en = mb_convert_encoding($detail_en, 'HTML-ENTITIES', 'UTF-8');
            $detail_en = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail_en);
            $de_e->loadHTML($detail_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images_de_e = $de_e->getElementsByTagName('img');
            libxml_use_internal_errors(true);
            foreach ($images_de_e as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/suy/Dp/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail_en = $de_e->saveHTML();
            $decodedTextdetail_en = html_entity_decode($detail_en, ENT_QUOTES, 'UTF-8');
         }

         $suruy->detail_en = $decodedTextdetail_en;

      }
      $suruy->survey_update = now();

      $suruy->survey_status = $request->input('survey_status', 0);

      $suruy->recommended = $request->input('recommended', 0);

      $suruy->save();


      return redirect()->route('surveyact', ['department_id' => $suruy->department_id, 'subject_id' => $suruy->subject_id])->with('message', 'Survey บันทึกข้อมูลสำเร็จ');
   }
   public function destorysub($survey_id)
   {
      $suruy = Survey::findOrFail($survey_id);
      $suruy->surs()->delete();
      $suruy->delete();
      return redirect()->back()->with('message', 'Survey ลบข้อมูลสำเร็จ');
   }



   public function changeStatus(Request $request)
   {
      $suruy = Survey::find($request->survey_id);

      if ($suruy) {
         $suruy->survey_status = $request->survey_status;
         $suruy->save();

         return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
      } else {
         return response()->json(['message' => 'ไม่พบข้อมูล survey_status']);
      }
   }


   public function QrCodepage(Request $request)
   {
   }
}
