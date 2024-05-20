<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAndSeed extends Command
{
    protected $signature = 'migrate:seed';

    protected $description = 'Run migrate:fresh and db:seed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('migrate:fresh'); // Run migrate:fresh
        $this->call('db:seed');       // Run db:seed
    }
}
