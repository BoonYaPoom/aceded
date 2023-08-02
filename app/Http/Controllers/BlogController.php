<?php

namespace App\Http\Controllers;

use App\Models\Blog;

use App\Models\BlogCategory;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index($category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        $blogs = $blogcat->blogs()->where('category_id',$category_id)->get();
        return view('page.dls.blog.cat.index',compact('blogcat','blogs')); 
    }
    
    public function create($category_id){
        $blogcat = BlogCategory::findOrFail($category_id);
        return view('page.dls.blog.cat.create',compact('blogcat'));
    }

    public function store(Request $request, $category_id){
        $request->validate([
            'title' => 'required',
            'detail' => 'required'
        ]);
        $latest_sort = Blog::max('sort');
        $new_sort = $latest_sort + 1;
        $blogs = new Blog ;
        $blogs->title=$request->title;
        $blogs->detail=$request->detail;
        $blogs->detail_en='';
        $blogs->date=now();
        $blogs->blog_status= $request->input('blog_status', 0);
        $blogs->author='TCCT';
        $blogs->comment=1;
        $blogs->recommended=1;
        $blogs->options=null;
        $blogs->options=2;
        $blogs->sort=$new_sort;
        $blogs->groupselect=0;
        $blogs->uid=2;
        $blogs->templete='';
        $blogs->bgcustom=null;
        $blogs->category_id = (int)$category_id;
        $blogs->save();


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


        return redirect()->route('blog',['category_id' => $category_id])->with('message','blog สร้างเรียบร้อยแล้ว');

    }
    public function edit($blog_id) {
        $blogs = Blog::findOrFail($blog_id);
        return view('page.dls.blog.cat.edit', ['blogs' => $blogs]);
    
    }

    public function update(Request $request, $blog_id){

        $request->validate([
            'title' => 'required',
            'detail' => 'required'
        ]);
        
        $blogs = Blog::findOrFail($blog_id);
        
        $blogs->title=$request->title;
        $blogs->detail=$request->detail;
        $blogs->date=now();
        $blogs->blog_status= $request->input('blog_status', 0);
        $blogs->author='TCCT';
        $blogs->comment=1;
        $blogs->recommended=1;
        $blogs->options=null;
        $blogs->options=2;
        $blogs->groupselect=0;
        $blogs->uid=2;
        $blogs->templete='';
        $blogs->bgcustom=null;
        $blogs->save();


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
   
        return redirect()->route('blog',['category_id' =>$blogs-> category_id])->with('message','blog เปลี่ยนแปลงเรียบร้อยแล้ว');
    }

    public function destory($blog_id){
        $blogs = Blog::findOrFail($blog_id);
   
    
        $blogs->delete();
        return redirect()->route('blogpage', ['category_id' => $blogs->category_id])->with('message','blog ลบข้อมูลเรียบร้อยแล้ว');

    }

    public function changeStatus(Request $request){
        $blogs = Blog::find($request->blog_id);
      
        if ($blogs) {
            $blogs->blog_status = $request->blog_status;
            $blogs->save();
          
            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Blog']);
        }
      }
}
