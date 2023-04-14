<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TruncateAndSeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate-and-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command truncates all tables and seeds the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Drop all tables and re-run all migrations
        $this->call('migrate:fresh');

        // Seed the database
        $this->call('db:seed');

        $this->info('Database truncated and seeded.');
    }
}
