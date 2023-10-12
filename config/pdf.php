<?php

return [
    'binary' => 'C:\Program Files\Glyph & Cog\XpdfReader-win64\xpdf.exe', // Replace with the actual path to pdftotext
    // config/pdf.php

    'font_path' => storage_path('fonts/TH/'), // เปลี่ยนเป็นเส้นทางไปยังโฟลเดอร์ที่มีไฟล์ฟอนต์
    'font_data' => [
        'THSarabun' => [
            'R' => 'THSarabun.ttf',
            'B' => 'THSarabun Bold.ttf',
        ],
        // เพิ่มฟอนต์อื่น ๆ ตามที่คุณต้องการ
    ],
    'font_cache' => storage_path('fonts/TH/'),

    // ...

    'paper_size' => 'A4',
    'orientation' => 'portrait', // 'portrait' หรือ 'landscape'
];
