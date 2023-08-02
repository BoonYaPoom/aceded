<?php

namespace App\Http\Controllers;


use App\Models\BlogCategory;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BlogCategotyController extends Controller
{
    public function blogpage(){
        $blogcat = BlogCategory::all();
       return view('page.dls.blog.index',compact('blogcat'));
    }

    public function create(){
        return view('page.dls.blog.create');
    }

    public function store(Request $request){
        $request->validate([
            'category_th' => 'required'
        
        ]);

        $blogcat = new BlogCategory;
        if ($request->hasFile('cover')) {
    
        $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
        Storage::disk('external')->put('Blog/' . $image_name, file_get_contents($request->cover));
        } else {
            $image_name = '';
        }

        $blogcat->cover = $image_name;
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
        
        // Loop through the conditions and check the user agent for the operating system
        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break; // Exit the loop once a match is found
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
            
        }

        
        if ($loginId) {
            $loginLog = Log::where('uid', $loginId)->where('logaction', 2)->first();
            
       
            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 2;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
            
        
            }

        
        $loginLog->save();

        return redirect()->route('blogpage',)->with('message','blog สร้างเรียบร้อยแล้ว');
    }

    public function edit($category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        return view('page.dls.blog.edit',['blogcat'=>$blogcat]);
    }

    public function update(Request $request,$category_id){
        $request->validate([
            'category_th' => 'required',
            'category_en' => 'required',
            'cover' => 'required'
        ]);
        
        $blogcat = BlogCategory::findOrFail($category_id);
        if ($request->hasFile('cover')) {
            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('Blog/' . $image_name, file_get_contents($request->cover));
            $blogcat->cover = $image_name;
         
        } 
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
        
        // Loop through the conditions and check the user agent for the operating system
        foreach ($conditions as $osName => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                $os = $osName;
                break; // Exit the loop once a match is found
            }
        }
        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
            
        }

        
        if ($loginId) {
            $loginLog = Log::where('uid', $loginId)->where('logaction', 3)->first();
            
       
            $loginLog = new Log;
            $loginLog->logid = 2;
            $loginLog->logaction = 3;
            $loginLog->logdetail = '';
            $loginLog->idref  = 1;
            $loginLog->subject_id  = 1;
            $loginLog->duration = 1;
            $loginLog->status  = 0;
            $loginLog->uid = $loginId;
            $loginLog->logagents = $browser;
            $loginLog->logip = $request->ip();

            $loginLog->logdate = now()->format('Y-m-d H:i:s');
            $loginLog->logplatform = $os;
            
        
            }

        
        $loginLog->save();

        
        return redirect()->route('blogpage')->with('message','blog เปลี่ยนแปลงเรียบร้อยแล้ว');
    }

    public function destroy($category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        $image_path = public_path()."/images/";
        $image_name = $image_path. $blogcat->cover;
        if(file_exists($image_name)){
            @unlink($image_name);


    }
    
        $blogcat->delete();
        return redirect()->route('blogpage', ['category_id' => $blogcat->category_id])->with('message','blog ลบข้อมูลเรียบร้อยแล้ว');

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
