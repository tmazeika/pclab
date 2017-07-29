<?php

namespace PCForge\Providers;

use Illuminate\Contracts\Foundation\Application;
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
use PCForge\Compatibility\Helpers\Selection;
use PCForge\Compatibility\Helpers\ShortestPaths;
use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\Repositories\ComponentRepository;
use PCForge\Compatibility\Services\ComparatorService;
use PCForge\Compatibility\Services\ComponentIncompatibilityService;
use PCForge\Compatibility\Services\SelectionStorageService;

class CompatibilityServiceProvider extends ServiceProvider
{
    protected $defer = true;

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
        $this->app->singleton(ComponentRepositoryContract::class, ComponentRepository::class);

        // IncompatibilityGraphContract
        $this->app->bind(IncompatibilityGraphContract::class, IncompatibilityGraph::class);

        // Selection Contract
        $this->app->singleton(SelectionContract::class, function (Application $app) {
            return $app->make(SelectionStorageServiceContract::class)->retrieve();
        });

        // SelectionStorageServiceContract
        $this->app->singleton(SelectionStorageServiceContract::class, SelectionStorageService::class);

        // ShortestPathsContract
        $this->app->bind(ShortestPathsContract::class, ShortestPaths::class);

        // SystemContract
        $this->app->bind(SystemContract::class, System::class);
    }

    public function provides()
    {
        return [
            ComparatorServiceContract::class,
            ComponentIncompatibilityServiceContract::class,
            ComponentRepositoryContract::class,
            IncompatibilityGraphContract::class,
            SelectionContract::class,
            SelectionStorageServiceContract::class,
            ShortestPathsContract::class,
            SystemContract::class,
        ];
    }

}
