<?php

namespace PCForge\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\Services\ComponentIncompatibilityService;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\SelectionContract;
use PCForge\Contracts\SelectionStorageServiceContract;
use PCForge\Contracts\SystemContract;

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
        $this->app->singleton(SelectionContract::class, function (Application $app) {
            return $app->make(SelectionStorageServiceContract::class)->retrieve();
        });

        $this->app->singleton(
            SystemContract::class,
            System::class);

        $this->app->bind(
            ComponentIncompatibilityServiceContract::class,
            ComponentIncompatibilityService::class
        );
    }
}
