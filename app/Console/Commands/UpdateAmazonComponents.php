<?php

namespace PCForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use PCForge\Jobs\UpdateAmazonComponents as UpdateAmazonComponentsJob;
use PCForge\Models\Component;

class UpdateAmazonComponents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-amazon-components';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Amazon availability and prices';

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
            ::lockForUpdate()
            ->pluck('asin')
            ->chunk(UpdateAmazonComponentsJob::MAX_ASINS_PER_REQUEST)
            ->each(function (Collection $asins, int $i) {
                $job = new UpdateAmazonComponentsJob($asins->toArray());

                dispatch($job->delay($i));
            });
    }
}
