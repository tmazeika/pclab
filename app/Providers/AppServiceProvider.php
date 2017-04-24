<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;
use PCForge\Contracts\BraintreeServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Repositories\ComponentRepository;
use PCForge\Repositories\ComponentSelectionService;
use PCForge\Services\BraintreeService;

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
            BraintreeServiceContract::class,
            BraintreeService::class
        );

        $this->app->bind(
            ComponentRepositoryContract::class,
            ComponentRepository::class
        );

        $this->app->bind(
            ComponentSelectionServiceContract::class,
            ComponentSelectionService::class
        );
    }
}
