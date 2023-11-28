<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Department;
use App\Models\Users;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function activiList($department_id, $category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $act = $actCat->activa()->where('category_id', $category_id)->get();
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.activitylist', compact('actCat', 'act', 'depart'));
    }
    public function activiListForm1($department_id, $category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat1item.create', compact('actCat', 'depart'));
    }
    public function act1store(Request $request, $department_id, $category_id)
    {

        $request->validate([
            'title' => 'required',
            'detail' => 'required'
        ]);


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = new Activity;
        $act->category_id = $category_id;
        $act->title = $request->title;
        $act->media = null;
        $act->location = null;
        $act->url = null;
        $act->startdate = $request->startdate;
        $act->enddate = $request->enddate;
        $act->starttime = null;
        $act->endtime = null;
        $act->frequency = null;
        $act->persontype = null;
        $act->comment = null;
        $act->options = null;
        $act->activity_status = $request->input('activity_status', 0);

        if (!file_exists(public_path('/upload/act/ck/'))) {
            mkdir(public_path('/upload/act/ck/'), 0755, true);
        }
        if ($request->has('detail')) {
            $detail = $request->detail;
            $decodedText = '';
            if (!empty($detail)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');
                $detail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail);
                $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_use_internal_errors(true);
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/act/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail = $de_th->saveHTML();
                $decodedText = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');
            }

            $act->detail = $decodedText;
        }
        $act->invite = null;
        $act->user_id = $loginId;
        $act->save();

        return redirect()->route('activiList', [$department_id, 'category_id' => $category_id])->with('message', 'Success Acti');
    }



    public function formacttivityEdit1($department_id, $activity_id)
    {
        $act = Activity::findOrFail($activity_id);
        $category_id = $act->category_id;
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat1item.edit', compact('act', 'actCat', 'depart'));
    }
    public function act1update(Request $request, $department_id, $activity_id)
    {


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = Activity::findOrFail($activity_id);

        $act->title = $request->title;

        $act->startdate = $request->startdate;
        $act->enddate = $request->enddate;

        $act->activity_status = $request->input('activity_status', 0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/upload/act/ck/'))) {
            mkdir(public_path('/upload/act/ck/'), 0755, true);
        }
        if ($request->has('detail')) {
            $detail = $request->detail;
            $decodedText = '';
            if (!empty($detail)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');
                $detail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail);
                $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_use_internal_errors(true);
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/act/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail = $de_th->saveHTML();
                $decodedText = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');
            }

            $act->detail = $decodedText;
        }

        $act->user_id = $loginId;
        $act->save();


        return redirect()->route('activiList', [$department_id, 'category_id' => $act->category_id])->with('message', 'Success Acti');
    }




    public function activiListForm2($department_id, $category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat2item.create', compact('actCat', 'depart'));
    }

    public function act2store(Request $request, $department_id, $category_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }

        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }

        try {

            $act = new Activity;
            $act->category_id = $category_id;
            $act->title = $request->title;

            if ($request->hasFile('media')) {
                $fileName = time() . '.' . $request->media->getClientOriginalExtension();
                $filePath = public_path('uploads'); // กำหนดพาธของโฟลเดอร์ที่เก็บไฟล์
                $request->media->move($filePath, $fileName);
            }
            $act->media = $fileName;
            $act->location = null;
            $act->url = null;
            $act->startdate = now();
            $act->enddate =  now();
            $act->starttime = null;
            $act->endtime = null;
            $act->frequency = null;
            $act->persontype = null;
            $act->comment = null;
            $act->options = null;
            $act->activity_status = $request->input('activity_status', 0);
            libxml_use_internal_errors(true);
            if (!file_exists(public_path('/upload/act/ck/'))) {
                mkdir(public_path('/upload/act/ck/'), 0755, true);
            }
            if ($request->has('detail')) {
                $detail = $request->detail;
                $decodedText = '';
                if (!empty($detail)) {
                    $de_th = new DOMDocument();
                    $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                    $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');
                    $detail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail);
                    $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images_des_th = $de_th->getElementsByTagName('img');

                    foreach ($images_des_th as $key => $img) {
                        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                            $image_name = '/upload/act/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                            file_put_contents(public_path() . $image_name, $data);
                            $img->removeAttribute('src');
                            $newImageUrl = asset($image_name);
                            $img->setAttribute('src', $newImageUrl);
                        }
                    }
                    $detail = $de_th->saveHTML();
                    $decodedText = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');
                }

                $act->detail = $decodedText;
            }
            $act->invite = null;
            $act->user_id = $loginId;
            $act->save();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->view('error.error-500', [], 500);
        }
        return redirect()->route('activiList', [$department_id, 'category_id' => $category_id])->with('message', 'Success Acti');
    }

    public function formacttivityEdit2($department_id, $activity_id)
    {
        $act = Activity::findOrFail($activity_id);
        $category_id = $act->category_id;
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat2item.edit', compact('act', 'actCat', 'depart'));
    }

    public function act2update(Request $request, $department_id, $activity_id)
    {


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = Activity::findOrFail($activity_id);

        $act->title = $request->title;
        if ($request->hasFile('media')) {
            $fileName = time() . '.' . $request->media->getClientOriginalExtension();
            $filePath = public_path('uploads'); // กำหนดพาธของโฟลเดอร์ที่เก็บไฟล์
            $request->media->move($filePath, $fileName);
        }
        $act->media = $fileName;
        $act->enddate = now();
        $act->activity_status = $request->input('activity_status', 0);
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/upload/act/ck/'))) {
            mkdir(public_path('/upload/act/ck/'), 0755, true);
        }
        if ($request->has('detail')) {
            $detail = $request->detail;
            $decodedText = '';
            if (!empty($detail)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');
                $detail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail);
                $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_des_th = $de_th->getElementsByTagName('img');

                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/act/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        file_put_contents(public_path() . $image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = asset($image_name);
                        $img->setAttribute('src', $newImageUrl);
                    }
                }
                $detail = $de_th->saveHTML();
                $decodedText = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');
            }

            $act->detail = $decodedText;
        }

        $act->user_id = $loginId;
        $act->save();


        return redirect()->route('activiList', [$department_id, 'category_id' => $act->category_id])->with('message', 'Success Acti');
    }

    public function changeStatus(Request $request)
    {
        $act = Activity::find($request->activity_id);

        if ($act) {
            $act->activity_status = $request->activity_status;
            $act->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Activity']);
        }
    }
}
