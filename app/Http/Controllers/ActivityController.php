<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function activiList($category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $act = $actCat->activa()->where('category_id', $category_id)->get();
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.activitylist', compact('actCat', 'act','depart'));
    }
    public function activiListForm1($category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat1item.create', compact('actCat','depart'));
    }
    public function act1store(Request $request, $category_id)
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
        $act->detail = $request->detail;
        $act->invite = null;
        $act->uid = $loginId;
        $act->save();

        return redirect()->route('activiList', ['category_id' => $category_id])->with('message', 'Success Acti');
    }



    public function formacttivityEdit1($activity_id)
    {
        $act = Activity::findOrFail($activity_id);
        $category_id = $act->category_id;
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat1item.edit', compact('act','actCat','depart'));
    }
    public function act1update(Request $request, $activity_id)
    {


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = Activity::findOrFail($activity_id);

        $act->title = $request->title;

        $act->startdate = $request->startdate;
        $act->enddate = $request->enddate;

        $act->activity_status = $request->input('activity_status', 0);
        $act->detail = $request->detail;

        $act->uid = $loginId;
        $act->save();


        return redirect()->route('activiList', ['category_id' => $act->category_id])->with('message', 'Success Acti');
    }




    public function activiListForm2($category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat2item.create', compact('actCat','depart'));
    }

    public function act2store(Request $request, $category_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'detail' => 'required'
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
        $act->detail = $request->detail;
        $act->invite = null;
        $act->uid = $loginId;
        $act->save();
        return redirect()->route('activiList', ['category_id' => $category_id])->with('message', 'Success Acti');
    }

    public function formacttivityEdit2($activity_id)
    {
        $act = Activity::findOrFail($activity_id);
        $category_id = $act->category_id;
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.item.cat2item.edit', compact('act','actCat','depart'));
    }

    public function act2update(Request $request, $activity_id)
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
        $act->detail = $request->detail;

        $act->uid = $loginId;
        $act->save();


        return redirect()->route('activiList', ['category_id' => $act->category_id])->with('message', 'Success Acti');
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
