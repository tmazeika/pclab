<?php

namespace PCForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use PCForge\Jobs\UpdateAmazonPrices as UpdateAmazonPricesJob;
use PCForge\Models\Component;

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
        Component
            ::pluck('asin')
            ->chunk(UpdateAmazonPricesJob::MAX_ASINS_PER_REQUEST)
            ->each(function (Collection $asins, int $i) {
                $job = new UpdateAmazonPricesJob($asins->toArray());

                dispatch($job->delay($i));
            });
    }
}
