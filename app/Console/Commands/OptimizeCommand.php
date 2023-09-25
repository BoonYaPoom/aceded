<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeCommand extends Command
{
    protected $signature = 'custom:optimize';

    protected $description = 'Optimize the application for better performance';

    public function handle()
    {
        $this->call('optimize');
    }
}
