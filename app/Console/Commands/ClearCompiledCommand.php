<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCompiledCommand extends Command
{
    protected $signature = 'custom:clear-compiled';

    protected $description = 'Remove the compiled class file';

    public function handle()
    {
        $this->call('clear-compiled');
    }
}
