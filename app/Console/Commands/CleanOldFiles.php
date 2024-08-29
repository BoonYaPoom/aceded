<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOldFiles extends Command
{
    protected $signature = 'clean:old-files';
    protected $description = 'Delete old files from the exports directory every 3 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $directory = 'public/exports';
        $files = Storage::files($directory);
        $thresholdDate = Carbon::now()->subDays(3);

        foreach ($files as $file) {
            // Get file modification time
            $fileDate = Carbon::createFromTimestamp(Storage::lastModified($file));

            if ($fileDate->lessThan($thresholdDate)) {
                Storage::delete($file);
                $this->info("Deleted old file: $file");
            }
        }

        $this->info('Old files cleanup completed.');
    }
}
