<?php

namespace App\Http\Controllers;

use App\Models\Blog;

use App\Models\BlogCategory;
use App\Models\Department;
use App\Models\Log;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index($department_id,$category_id)
    {
        $blogcat = BlogCategory::findOrFail($category_id);
        $blogs = $blogcat->blogs()->where('category_id', $category_id)->get();
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.index', compact('blogcat', 'blogs', 'depart'));
    }

    public function create($department_id,$category_id)
    {
        $blogcat = BlogCategory::findOrFail($category_id);
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.create', compact('blogcat', 'depart'));
    }

    public function store(Request $request,$department_id, $category_id)
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
        try{
        $latest_sort = Blog::max('sort');
        $new_sort = $latest_sort + 1;
        $blogs = new Blog;
        $blogs->title = $request->title;
        $blogs->title_en = $request->title;

                     
      libxml_use_internal_errors(true);
      if (!file_exists(public_path('/upload/Blog/ck/'))) {
         mkdir(public_path('/upload/Blog/ck/'), 0755, true);
      }
      if ($request->has('detail')) {
         $detail = $request->detail;
         if (!empty($detail)) {
            $de_th = new DOMDocument();
            $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
            $de_th->loadHTML(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images_des_th = $de_th->getElementsByTagName('img');

            foreach ($images_des_th as $key => $img) {
               if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                  $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                  $image_name = '/upload/Blog/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                  file_put_contents(public_path() . $image_name, $data);
                  $img->removeAttribute('src');
                  $newImageUrl = asset($image_name);
                  $img->setAttribute('src', $newImageUrl);
               }
            }
            $detail = $de_th->saveHTML();
         }

         $blogs->detail = $detail;
      }
        $blogs->detail_en =  $request->detail;
        $blogs->blog_date = now();
        $blogs->blog_status = $request->input('blog_status', 0);
        $blogs->author = 'TCCT';
        $blogs->comment = 1;
        $blogs->recommended = 1;
        $blogs->options = null;
        $blogs->options = 2;
        $blogs->sort = $new_sort;
        $blogs->groupselect = 0;
        $blogs->user_id = 2;
        $blogs->templete = '';
        $blogs->bgcustom = null;
        $blogs->category_id = (int)$category_id;
        $blogs->save();
        DB::commit();
    } catch (\Exception $e) {

        DB::rollBack();
        
        return response()->view('error.error-500', [], 500);
    }

        if (Session::has('loginId')) {
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


        return redirect()->route('blog', [$department_id,'category_id' => $category_id])->with('message', 'blog สร้างเรียบร้อยแล้ว');
    }
    public function edit($department_id,$blog_id)
    {
        $blogs = Blog::findOrFail($blog_id);
        $category_id = $blogs->category_id;
        $blogcat = BlogCategory::findOrFail($category_id);
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.edit', ['blogs' => $blogs, 'blogcat' => $blogcat, 'depart' => $depart]);
    }

    public function update(Request $request,$department_id, $blog_id)
    {

        $request->validate([
            'title' => 'required',
            'detail' => 'required'
        ]);

        $blogs = Blog::findOrFail($blog_id);

        $blogs->title = $request->title;
        libxml_use_internal_errors(true);
        if (!file_exists(public_path('/upload/Blog/ck/'))) {
           mkdir(public_path('/upload/Blog/ck/'), 0755, true);
        }
        if ($request->has('detail')) {
           $detail = $request->detail;
           if (!empty($detail)) {
              $de_th = new DOMDocument();
              $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
              $de_th->loadHTML(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  
              $images_des_th = $de_th->getElementsByTagName('img');
  
              foreach ($images_des_th as $key => $img) {
                 if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = '/upload/Blog/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $newImageUrl = asset($image_name);
                    $img->setAttribute('src', $newImageUrl);
                 }
              }
              $detail = $de_th->saveHTML();
           }
  
           $blogs->detail = $detail;
        }
        $blogs->blog_date = now();
        $blogs->blog_status = $request->input('blog_status', 0);
        $blogs->author = 'TCCT';
        $blogs->comment = 1;
        $blogs->recommended = 1;
        $blogs->options = null;
        $blogs->options = 2;
        $blogs->groupselect = 0;
        $blogs->user_id = 2;
        $blogs->templete = '';
        $blogs->bgcustom = null;
        $blogs->save();


        if (Session::has('loginId')) {
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

        return redirect()->route('blog', [$department_id,'category_id' => $blogs->category_id])->with('message', 'blog เปลี่ยนแปลงเรียบร้อยแล้ว');
    }

    public function destory($blog_id)
    {
        $blogs = Blog::findOrFail($blog_id);


        $blogs->delete();
        return redirect()->back()->with('message', 'blog ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function changeStatus(Request $request)
    {
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
