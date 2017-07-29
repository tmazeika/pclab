<?php

namespace PCForge\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use PCForge\Compatibility\Contracts\ComparatorServiceContract;
use PCForge\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Compatibility\Contracts\IncompatibilityGraphContract;
use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Compatibility\Contracts\SelectionStorageServiceContract;
use PCForge\Compatibility\Contracts\ShortestPathsContract;
use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Compatibility\Helpers\IncompatibilityGraph;
use PCForge\Compatibility\Helpers\ShortestPaths;
use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\Repositories\ComponentRepository;
use PCForge\Compatibility\Services\ComparatorService;
use PCForge\Compatibility\Services\ComponentIncompatibilityService;
use PCForge\Compatibility\Services\SelectionStorageService;

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
        // ComparatorServiceContract
        $this->app->bind(ComparatorServiceContract::class, ComparatorService::class);

        // ComponentIncompatibilityServiceContract
        $this->app->bind(ComponentIncompatibilityServiceContract::class, ComponentIncompatibilityService::class);

        // ComponentRepositoryContract
        $this->app->bind(ComponentRepositoryContract::class, ComponentRepository::class);

        // IncompatibilityGraphContract
        $this->app->bind(IncompatibilityGraphContract::class, IncompatibilityGraph::class);

        // Selection Contract
        $this->app->singleton(SelectionContract::class, function (Application $app) {
            return $app->make(SelectionStorageServiceContract::class)->retrieve();
        });

        // SelectionStorageServiceContract
        $this->app->bind(SelectionStorageServiceContract::class, SelectionStorageService::class);

        // ShortestPathsContract
        $this->app->bind(ShortestPathsContract::class, ShortestPaths::class);

        // SystemContract
        $this->app->bind(SystemContract::class, System::class);
    }
}
