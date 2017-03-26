<?php

namespace PCForge\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use PCForge\Jobs\UpdateAmazonPrices;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $now = Carbon::now();
            $secondsToAdd = 0;

            DB::table('components')->select('asin')->orderBy('asin')->chunk(10, function($components) use ($now, &$secondsToAdd) {
                $asins = [];

                foreach ($components as $component) {
                    array_push($asins, $component->asin);
                }

                dispatch((new UpdateAmazonPrices($asins))->delay($now->addSeconds($secondsToAdd++)));
            });
        })->twiceDaily(6, 18)->evenInMaintenanceMode();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
