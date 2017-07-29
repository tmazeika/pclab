<?php

namespace PCForge\Console\Commands;

use Illuminate\Console\Command;

class ResetAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes and seeds the database, clears cache and sessions, updates Amazon prices, and optionally updates the compatibilities table';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (app()->isLocal() || $this->confirm('This will refresh migrations and clear cache and sessions! Continue?')) {
            // clear cache
            $this->call('cache:clear');

            // update database
            $this->call('migrate:refresh', ['--seed' => true]);
            $this->call('update-amazon-components');
        }
    }
}
