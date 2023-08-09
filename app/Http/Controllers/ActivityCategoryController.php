<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\ActivityInvite;
use Illuminate\Http\Request;

class ActivityCategoryController extends Controller
{
    public function activi(){
        $actCat = ActivityCategory::all();
        return view('page.dls.cop.activitycat.index',compact('actCat'));
    }


    public function activiFrom($category_id){
        $actCat = ActivityCategory::findOrFail($category_id);
        return view('page.dls.cop.activitycat.activityfrom',compact('actCat'));
    }
    public function storeAct($category_id){
        $actCat = ActivityCategory::findOrFail($category_id);
        return view('page.dls.cop.activitycat.activityfrom',compact('actCat'));
    }

  

    public function meeti(){
        $actCat = ActivityCategory::all();
        return view('page.dls.cop.meetingcat.index',compact('actCat'));
    }
    public function changeStatus(Request $request){
        $actCat = ActivityCategory::find($request->category_id);
      
        if ($actCat) {
            $actCat->category_status = $request->category_status;
            $actCat->save();
          
            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล ActivityCategory']);
        }
    }
}
