<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public function activiList($category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);
        $act = $actCat->activa()->where('category_id', $category_id)->get();
        return view('page.dls.cop.activitycat.activitylist', compact('actCat', 'act'));
    }
    public function activiListForm1($category_id)
    {
        $actCat = ActivityCategory::findOrFail($category_id);

        return view('page.dls.cop.activitycat.item.cat1item.create', compact('actCat'));
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
        return view('page.dls.cop.activitycat.item.cat1item.edit', compact('act'));
    }
    public function act1update(Request $request, $activity_id)
    {


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = ActivityCategory::findOrFail($activity_id);

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
        $act = ActivityCategory::findOrFail($category_id);
        return view('page.dls.cop.activitycat.item.cat2item.create', compact('actCat'));
    }

    public function act2store(Request $request, $category_id)
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
        $act->startdate = now();
        $act->enddate = null;
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
        return view('page.dls.cop.activitycat.item.cat2item.edit', compact('act'));
    }

    public function act2update(Request $request, $activity_id)
    {


        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
        }
        $act = ActivityCategory::findOrFail($activity_id);

        $act->title = $request->title;
        $act->media = null;

        $act->enddate = now();
        $act->activity_status = $request->input('activity_status', 0);
        $act->detail = $request->detail;

        $act->uid = $loginId;
        $act->save();


        return redirect()->route('activiList', ['category_id' => $act->category_id])->with('message', 'Success Acti');
    }

}
