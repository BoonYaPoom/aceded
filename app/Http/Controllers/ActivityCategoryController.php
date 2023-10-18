<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\ActivityInvite;
use App\Models\Department;
use Illuminate\Http\Request;

class ActivityCategoryController extends Controller
{
    public function activi($department_id){
  
        $depart = Department::findOrFail($department_id);
        $actCat  = $depart->ActCatDe()->where('department_id', $department_id)->get();
        return view('page.dls.cop.activitycat.index',compact('actCat','depart'));
    }


    public function activiFrom($department_id,$category_id){
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.activityfrom',compact('actCat','depart'));
    }
    public function storeAct($department_id,$category_id){
        $actCat = ActivityCategory::findOrFail($category_id);
        $department_id   = $actCat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.cop.activitycat.activityfrom',compact('actCat','depart'));
    }

  

    public function meeti($department_id){

        $depart = Department::findOrFail($department_id);
        $actCat  = $depart->ActCatDe()->where('department_id', $department_id)->get();
  
        return view('page.dls.cop.meetingcat.index',compact('actCat','depart'));
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
