<?php

namespace App\Http\Controllers;

use App\Models\CourseGroup;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseGroupController extends Controller
{
   public function courgroup($department_id){

    $depart  = Department::findOrFail($department_id);
    $courses = $depart->degroup()->where('department_id', $department_id)->get(); 
    return view('page.manage.group.index',compact('courses','depart'));
   }
   public function create($department_id){
    $depart  = Department::findOrFail($department_id);
    return view('page.manage.group.create',compact('depart'));
   }
   public function store(Request $request,$department_id){
    $request->validate([
        'group_th' => 'required'
    ]);
try{
    $courses = new CourseGroup;
    $courses->group_th = $request->group_th;
    $courses->group_en = $request->group_en;
    $courses->department_id = (int)$department_id;
    $courses->group_status  = $request->input('group_status ', 0);
    $courses->save();
    DB::commit();
} catch (\Exception $e) {

    DB::rollBack();

    return response()->view('error.error-500', [], 500);
}
    return redirect()->route('courgroup',['department_id' => $department_id])->with('message','CourseGroup บันทึกข้อมูลสำเร็จ');

   }
   
   public function edit($department_id,$group_id){
    $courses = CourseGroup::findOrFail($group_id);
    $department_id = $courses->department_id;
    $depart  = Department::findOrFail($department_id);
    return view('page.manage.group.edit', compact('courses','depart'));
   }

   public function update(Request $request,$department_id, $group_id){

    $validator = Validator::make($request->all(), [
        'group_th' => 'required'

    ]);
  
    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'ข้อมูลไม่ถูกต้อง');
    }
    $courses = CourseGroup::findOrFail($group_id);
    $courses->group_th = $request->group_th;
    $courses->group_en = $request->group_en;
    $courses->department_id = 12;
    $courses->group_status  = $request->input('group_status ', 0);
    $courses->save();

    return redirect()->route('courgroup',[$department_id])->with('message','CourseGroup บันทึกข้อมูลสำเร็จ');

   }
   

   public function destroy($group_id){
    $courses = CourseGroup::findOrFail($group_id);
    $courses -> delete();
    return redirect()->back()->with('message','CourseGroup ลบข้อมูลสำเร็จ');
   }
   public function changeStatus(Request $request){
    $courses = CourseGroup::find($request->group_id);
  
    if ($courses) {
        $courses->group_status = $request->group_status;
        $courses->save();
      
        return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
    } else {
        return response()->json(['message' => 'ไม่พบข้อมูล CourseGroup']);
    }
  }

}
