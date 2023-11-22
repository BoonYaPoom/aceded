<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

class SchoolDepartUserController extends Controller
{

    public function requestSchool(Request $request)
    {

        return view("layouts.department.item.data.requline.index");
    }
   
public function uploadPdf(Request $request)
{
    $request->validate([
        'pdf_file' => 'required|mimes:pdf|max:10240',
    ]);

    $pdfFile = $request->file('pdf_file');

    // บันทึกไฟล์ PDF ในโฟลเดอร์ public
    $pdfPath = Storage::disk('public')->putFileAs('pdfs', $pdfFile, $pdfFile->getClientOriginalName());

    // เรียกใช้ฟังก์ชันสำหรับแยกไฟล์ PDF เป็นรูป
    $this->convertPdfToImages(storage_path('app/public/' . $pdfPath));

    // เพิ่มโค้ดอื่นๆ ตามที่ต้องการทำหลังจากการแยกไฟล์

    return redirect()->back()->with('success', 'PDF uploaded and images created successfully.');
}

// ...

private function convertPdfToImages($pdfPath)
{
    $pdf = new Pdf($pdfPath);
    $pdf->setResolution(50); 

    $pdf->setOutputFormat('png');
    $imagesDirectory = storage_path('app/public/images');

    // ตรวจสอบว่าโฟลเดอร์ images มีหรือยัง
    if (!file_exists($imagesDirectory)) {
        // ถ้ายังไม่มี, ให้สร้างโฟลเดอร์
        mkdir($imagesDirectory, 0755, true);
    }

    $pdf->saveAllPagesAsImages($imagesDirectory);
}
}
