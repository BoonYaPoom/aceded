<?php

namespace App\Http\Controllers;


use App\Models\BookCategory;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BookCategoryController extends Controller
{

    public function bookpage()
    {
        $book = BookCategory::all();
        return view('page.dls.book.book', compact('book'));
    }
    public function create()
    {
        return view('page.dls.book.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_th' => 'required',
            'cover' => 'required'
        ]);
        $book = new BookCategory;
        $book->category_th = $request->category_th;
        $book->category_en  = $request->category_en;
        $book->detail_th = '';
        $book->detail_en = '';
        $book->category_date = now();
        $book->category_status = $request->input('category_status', 0);
        $book->category_type = 1;
        $book->category_option = '';
        $book->recommended = 1;

        $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
        Storage::disk('external')->put('BookCategory/' . $image_name, file_get_contents($request->cover));

        $book->cover = $image_name;
        $book->save();



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


        return redirect()->route('bookpage',)->with('message', 'book สร้างเรียบร้อยแล้ว');
    }

    public function edit($category_id)
    {
        $book = BookCategory::findOrFail($category_id);
        return view('page.dls.book.edit', compact('book'));
    }

    public function update(Request $request, $category_id)
    {
        $request->validate([
            'category_th' => 'required',
            'cover' => 'required'
        ]);
        $book = BookCategory::findOrFail($category_id);
        $book->category_th = $request->category_th;
        $book->category_en  = $request->category_en;
        $book->detail_th = '';
        $book->detail_en = '';
        $book->category_update = now();
        $book->category_status = 1;
        $book->category_type = 1;
        $book->category_option = '';
        $book->recommended = 1;
        if ($request->hasFile('cover')) {

            $image_name = time() . '.' . $request->cover->getClientOriginalExtension();
            Storage::disk('external')->put('BookCategory/' . $image_name, file_get_contents($request->cover));
            $book->cover = $image_name;
        }

        $book->save();
        return redirect()->route('bookpage',)->with('message', 'book    เปลี่ยนแปลงเรียบร้อยแล้ว');
    }
    public function destory($category_id)
    {
        $book = BookCategory::findOrFail($category_id);

        $book->delete();
        return redirect()->route('bookpage',)->with('message', 'book  ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function changeStatus(Request $request)
    {
        $book = BookCategory::find($request->category_id);

        if ($book) {
            $book->category_status = $request->category_status;
            $book->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล BookCategory']);
        }
    }
}
