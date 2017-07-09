<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;
use PCForge\Contracts\BraintreeServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\SelectionStorageServiceContract;
use PCForge\Repositories\ComponentRepository;
use PCForge\Services\BraintreeService;
use PCForge\Services\SelectionStorageService;

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
            SelectionStorageServiceContract::class,
            SelectionStorageService::class
        );
    }
}
