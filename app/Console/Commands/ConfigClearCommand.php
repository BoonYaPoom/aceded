<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConfigClearCommand extends Command
{
    protected $signature = 'custom:config-clear';

    protected $description = 'Clear the configuration cache';

    public function handle()
    {
        $this->call('config:clear');
    }
}
