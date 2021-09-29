<?php

namespace WebId\Persil\Commands;

use Illuminate\Console\Command;

class PersilCommand extends Command
{
    public $signature = 'persil';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
