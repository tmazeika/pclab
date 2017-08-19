<?php

namespace PCLab\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use PCLab\Compatibility\Contracts\ComparatorServiceContract;
use PCLab\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCLab\Compatibility\Contracts\ComponentRepositoryContract;
use PCLab\Compatibility\Contracts\IncompatibilityGraphContract;
use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Compatibility\Contracts\SelectionStorageServiceContract;
use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Compatibility\Helpers\IncompatibilityGraph;
use PCLab\Compatibility\Helpers\System;
use PCLab\Compatibility\Repositories\ComponentRepository;
use PCLab\Compatibility\Services\ComparatorService;
use PCLab\Compatibility\Services\ComponentIncompatibilityService;
use PCLab\Compatibility\Services\SelectionStorageService;

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
            SystemContract::class,
        ];
    }

}
