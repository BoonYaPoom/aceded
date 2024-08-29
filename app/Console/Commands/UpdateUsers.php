<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UpdateUsers extends Command
{
    protected $signature = 'export:users';
    protected $description = 'Export users data to Excel nightly';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // ตรวจสอบไฟล์ที่มีอยู่
        $files = Storage::files('public/exports');
        $count = count($files);

        // สร้างชื่อไฟล์ใหม่
        $filePath = 'exports/Administrator Management Users ' . ($count + 1) . '.xlsx';

        // บันทึกไฟล์
        Excel::store(new UsersExport(), $filePath, 'public');

        // ข้อความ debug
        $this->info('Users data has been exported successfully.');
        $this->info("New file path: $filePath");
        $this->info("Total files now: " . ($count + 1));
    }

}
