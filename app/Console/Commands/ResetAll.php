<?php

namespace PCForge\Console\Commands;

use Illuminate\Console\Command;
use PCForge\Events\ComponentModified;

class ResetAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-all {--compatibilities}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes and seeds the database, clears cache, updates Amazon prices, and optionally updates the compatibilities table';

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
        if (!$this->confirm('This will refresh migrations and clear cache! Continue?')) {
            return;
        }

        $compatibilities = $this->option('compatibilities');

        $this->call('migrate:refresh', ['--seed' => true]);
        $this->call('cache:clear');
        $this->call('update-amazon-prices');

        if ($compatibilities) {
            event(new ComponentModified);
        }
    }
}
