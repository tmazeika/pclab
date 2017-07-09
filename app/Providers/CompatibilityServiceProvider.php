<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;
use PCForge\Compatibility\Helpers\Selection;
use PCForge\Compatibility\Services\ComponentIncompatibilityService;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;

class CompatibilityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Selection::class); // TODO: not a singleton by default?

        $this->app->bind(
            ComponentIncompatibilityServiceContract::class,
            ComponentIncompatibilityService::class
        );
    }
}
