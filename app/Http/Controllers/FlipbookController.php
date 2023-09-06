<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

class FlipbookController extends Controller
{
    public function index()
    {
        return view('flipbook.index');
    }

    public function convert(Request $request)
    {
       // 1. รับไฟล์ PDF จากฟอร์ม
       $pdfFile = $request->file('pdf');

       // 2. สร้างโฟลเดอร์เพื่อเก็บรูปภาพที่แปลง
       $outputPath = public_path('flipbook');
       File::makeDirectory($outputPath, $mode = 0777, true, true);

       // 3. แปลง PDF เป็นรูปภาพ
       $pdf = new Pdf($pdfFile->getPathname());
       $pages = $pdf->getNumberOfPages();
       for ($page = 1; $page <= $pages; $page++) {
           $imagePath = "{$outputPath}/page{$page}.jpg";
           $pdf->setPage($page)
               ->setOutputFormat('jpg')
               ->saveImage($imagePath);
       }

       // 4. สร้าง HTML flip book
       // คุณสามารถใช้ไลบรารี JavaScript เช่น FlipBook.js หรือแบบที่คุณต้องการ

       // 5. บันทึก HTML ของ flip book ลงในไฟล์
       $htmlContent = "<html><head></head><body>";
       for ($page = 1; $page <= $pages; $page++) {
           $htmlContent .= "<img src='flipbook/page{$page}.jpg'>";
       }
       $htmlContent .= "</body></html>";

       $htmlFile = public_path('flipbook/book.html');
       file_put_contents($htmlFile, $htmlContent);
    }
}
