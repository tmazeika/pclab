<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;
use PCForge\Contracts\BraintreeServiceContract;
use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Repositories\ComponentRepository;
use PCForge\Repositories\ComponentSelectionService;
use PCForge\Services\BraintreeService;
use PCForge\Services\ComponentCompatibilityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ComponentCompatibilityServiceContract::class,
            ComponentCompatibilityService::class
        );

        $this->app->singleton(
            BraintreeServiceContract::class,
            BraintreeService::class
        );

        $this->app->singleton(
            ComponentSelectionServiceContract::class,
            ComponentSelectionService::class
        );

        $this->app->singleton(
            ComponentRepositoryContract::class,
            ComponentRepository::class
        );
    }
}
