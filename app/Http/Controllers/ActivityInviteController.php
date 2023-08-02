<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\ActivityInvite;
use Illuminate\Http\Request;

class ActivityInviteController extends Controller
{
    public function activiInvite($category_id){
        
        $actCat = ActivityCategory::findOrFail($category_id);
        $act = $actCat->activa()->where('category_id',$category_id)->get();
        return view('page.dls.cop.activitycat.activityinvite',compact('act','actCat'));
    }
}
