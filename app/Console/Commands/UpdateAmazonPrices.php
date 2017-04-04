<?php

namespace PCForge\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PCForge\Jobs\UpdateAmazonPrices as UpdateAmazonPricesJob;

class UpdateAmazonPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-amazon-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Amazon prices';

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
        $now = Carbon::now();
        $secondsToDelay = 0;

        DB::table('components')->select('asin')->orderBy('asin')->chunk(10, function($components) use ($now, &$secondsToDelay) {
            $asins = [];

            foreach ($components as $component) {
                array_push($asins, $component->asin);
            }

            dispatch((new UpdateAmazonPricesJob($asins))->delay($now->addSeconds($secondsToDelay++)));
        });
    }
}
