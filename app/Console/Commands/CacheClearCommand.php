<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class CacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
  

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    protected $signature = 'custom:cache-clear';

    protected $description = 'Clear the application cache';

    public function handle()
    {
        $this->call('cache:clear');
        Log::info('Custom command executed successfully.');
    }
}
