<?php

namespace App\Http\Controllers;


use App\Models\BlogCategory;
use App\Models\Department;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogCategotyController extends Controller
{
    public function blogpage($department_id){

        $depart = Department::findOrFail($department_id);
        $blogcat  = $depart->BlogCatDe()->where('department_id', $department_id)->get();
       return view('page.dls.blog.index',compact('blogcat','depart'));
    }

    public function create($department_id){
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.create',compact('depart'));
    }

    public function store(Request $request , $department_id){
     
        $validator = Validator::make($request->all(), [
            'category_th' => 'required'
        
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'ข้อมูลไม่ถูกต้อง');
        }
        try {
       
        $blogcat = new BlogCategory;

      

        $blogcat -> category_th =$request->category_th;
        $blogcat -> category_en =$request->category_en;
        $blogcat->detail_th = '';
        $blogcat->detail_en = '';
        $blogcat->category_date=now();
        $blogcat->category_status = $request->input('category_status', 0);
        $blogcat->category_type =1;
        $blogcat->category_option =null;
        $blogcat->department_id =(int)$department_id;
        $blogcat->recommended =1;
        $blogcat->save();

        if ($request->hasFile('cover')) {
            $image_name = 'cover' . $blogcat->category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Blogcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Blogcategory/' . $image_name), file_get_contents($request->cover));
                $blogcat->cover = 'upload/Blogcategory/' .   'cover' . $blogcat->category_id . '.' . $request->cover->getClientOriginalExtension();
                $blogcat->save();
            }
        } 
         else {
            $image_name = '';
            $blogcat->cover = $image_name;
            $blogcat->save();
        }
        DB::commit();
    } catch (\Exception $e) {

        DB::rollBack();
        
        return response()->view('error.error-500', [], 500);
    }
        if(Session::has('loginId')){
            $loginId = Session::get('loginId');
         
            $userAgent = $request->header('User-Agent');
    
         
        }
        $conditions = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh|Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad|iPod',
        ];
        
        $os = '';
        
  
        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break;
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
            
        }

        
        if ($loginId) {
            $loginLog = Log::where('user_id', $loginId)->where('logaction', 2)->first();
            
       
            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 2;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->user_id = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
            
        
            }

        
        $loginLog->save();

        return redirect()->route('blogpage',['department_id'=>$department_id])->with('message','blog สร้างเรียบร้อยแล้ว');
    }

    public function edit($department_id,$category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.edit',['blogcat'=>$blogcat ,'depart'=>$depart]);
    }

    public function update(Request $request,$department_id,$category_id){
        $request->validate([
            'category_th' => 'required',
        ]);
        
        $blogcat = BlogCategory::findOrFail($category_id);
      
        $blogcat -> category_th =$request->category_th;
        $blogcat -> category_en =$request->category_en;
        $blogcat->detail_th = '';
        $blogcat->detail_en = '';
        $blogcat->category_date=now();
        $blogcat->category_status = $request->input('category_status', 0);
        $blogcat->category_type ='';
        $blogcat->category_option ='';
        $blogcat->recommended =1;
        $blogcat->save();
        if ($request->hasFile('cover')) {
            $image_name = 'cover' . $category_id . '.' . $request->cover->getClientOriginalExtension();
            $uploadDirectory = public_path('upload/Blogcategory/');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            if (file_exists($uploadDirectory)) {

                file_put_contents(public_path('upload/Blogcategory/' . $image_name), file_get_contents($request->cover));
                $blogcat->cover = 'upload/Blogcategory/' .   'cover' . $category_id . '.' . $request->cover->getClientOriginalExtension();
                $blogcat->save();
            }
        } 

        if(Session::has('loginId')){
            $loginId = Session::get('loginId');
         
            $userAgent = $request->header('User-Agent');
    
         
        }
        $conditions = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh|Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad|iPod',
        ];
        
        $os = '';

        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break; 
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
            
        }

        
        if ($loginId) {
            $loginLog = Log::where('user_id', $loginId)->where('logaction', 3)->first();
            
       
            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 3;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->user_id = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
            
        
            }

        
        $loginLog->save();

        
        return redirect()->route('blogpage',['department_id' => $blogcat->department_id])->with('message','blog เปลี่ยนแปลงเรียบร้อยแล้ว');
    }

    public function destroy($category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        $image_path = public_path()."/images/";
        $image_name = $image_path. $blogcat->cover;
        if(file_exists($image_name)){
            @unlink($image_name);


    }
    
        $blogcat->delete();
        return redirect()->back()->with('message','blog ลบข้อมูลเรียบร้อยแล้ว');

    }

    
    public function changeStatus(Request $request){
        $blogcat = BlogCategory::find($request->category_id);
      
        if ($blogcat) {
            $blogcat->category_status = $request->category_status;
            $blogcat->save();
          
            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล BlogCategory']);
        }
      }
}
