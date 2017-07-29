<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;
use PCForge\Contracts\BraintreeServiceContract;
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
    }
}
