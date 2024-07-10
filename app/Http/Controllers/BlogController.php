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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index($department_id, $category_id)
    {
        $blogcat = BlogCategory::findOrFail($category_id);
        $blogs = $blogcat->blogs()->where('category_id', $category_id)->get();
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.index', compact('blogcat', 'blogs', 'depart'));
    }

    public function create($department_id, $category_id)
    {
        $blogcat = BlogCategory::findOrFail($category_id);
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.create', compact('blogcat', 'depart'));
    }

    public function store(Request $request, $department_id, $category_id)
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

        $latest_sort = Blog::max('sort');
        $new_sort = $latest_sort + 1;
        $blogs = new Blog;
        $blogs->title = $request->title;
        $blogs->title_en = $request->title;

        if ($request->has('detail')) {
            $detail = $request->detail;

            $decodedText = '';
            if (!empty($detail)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8';
                libxml_use_internal_errors(true);
                $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');
                $detail = preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/is', '$1', $detail);
                $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $images_des_th = $de_th->getElementsByTagName('img');
                if (!Storage::disk('sftp')->exists('/upload/Blog/ck/')) {
                    Storage::disk('sftp')->makeDirectory('/upload/Blog/ck/');
                }
                
                libxml_use_internal_errors(false);
                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Blog/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        Storage::disk('sftp')->put($image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                        $img->setAttribute('src', $newImageUrl);
                        $img->removeAttribute('data-filename');
                    }
                }
                
                $detail_full = html_entity_decode($de_th->saveHTML(), ENT_QUOTES, 'UTF-8');
                $decodedText = htmlentities($detail_full);
                $detail_fullaaa = strip_tags($detail_full);
            }

            $blogs->detail = $decodedText;
            $blogs->plaintext = $detail_fullaaa;
        }


        $blogs->plaintext_en =  null;
        $blogs->detail_en =  0;
        $blogs->blog_date = now();
        $blogs->blog_status = $request->input('blog_status', 0);
        $blogs->author = 'ACED';
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


        return redirect()->route('blog', [$department_id, 'category_id' => $category_id])->with('message', 'blog สร้างเรียบร้อยแล้ว');
    }
    public function edit($department_id, $blog_id)
    {
        $blogs = Blog::findOrFail($blog_id);
        $category_id = $blogs->category_id;
        $blogcat = BlogCategory::findOrFail($category_id);
        $department_id   = $blogcat->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.dls.blog.cat.edit', ['blogs' => $blogs, 'blogcat' => $blogcat, 'depart' => $depart]);
    }

    public function update(Request $request, $department_id, $blog_id)
    {

        $request->validate([
            'title' => 'required',
            'detail' => 'required'
        ]);

        $blogs = Blog::findOrFail($blog_id);

        $blogs->title = $request->title;

        if ($request->has('detail')) {
            $detail = $request->detail;

            $decodedText = '';
            if (!empty($detail)) {
                $de_th = new DOMDocument();
                $de_th->encoding = 'UTF-8'; // กำหนด encoding เป็น UTF-8
                $detail = mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8');

                libxml_use_internal_errors(true);
                $de_th->loadHTML($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors();

                $images_des_th = $de_th->getElementsByTagName('img');
                if (!Storage::disk('sftp')->exists('/upload/Blog/ck/')) {
                    Storage::disk('sftp')->makeDirectory('/upload/Blog/ck/');
                }
            

                libxml_use_internal_errors(false);
                foreach ($images_des_th as $key => $img) {
                    if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                        $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                        $image_name = '/upload/Blog/ck/' . time() . $key . '.png'; // ใส่ .png เพื่อให้เป็นนามสกุลไฟล์ถูกต้อง
                        Storage::disk('sftp')->put($image_name, $data);
                        $img->removeAttribute('src');
                        $newImageUrl = env('URL_FILE_SFTP') . $image_name;
                        $img->setAttribute('src', $newImageUrl);
                        $img->removeAttribute('data-filename');
                    }
                }
                $detail_full = html_entity_decode($de_th->saveHTML(), ENT_QUOTES, 'UTF-8');
                $decodedText = htmlentities($detail_full);
                $detail_fullaaa = strip_tags($detail_full);
                //     $decodedText = htmlentities($detail, ENT_QUOTES, 'UTF-8'); 
                //  $decodedText = htmlspecialchars($detail, ENT_QUOTES); 
            }

            $blogs->detail = $decodedText;
            $blogs->plaintext = $detail_fullaaa;
        }

        $blogs->plaintext_en =  null;
        $blogs->detail_en =  0;
        $blogs->blog_date = now();
        $blogs->blog_status = $request->input('blog_status', 0);
        $blogs->author = 'ACED';
        $blogs->comment = 1;
        $blogs->recommended = 1;
        $blogs->options = null;
        $blogs->options = 2;
        $blogs->groupselect = 0;
        $blogs->user_id = 2;
        $blogs->templete = '';
        $blogs->bgcustom = null;
        $blogs->save();


        return redirect()->route('blog', [$department_id, 'category_id' => $blogs->category_id])->with('message', 'blog เปลี่ยนแปลงเรียบร้อยแล้ว');
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
