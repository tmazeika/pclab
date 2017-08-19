<?php

namespace PCLab\Providers;

use Illuminate\Support\ServiceProvider;
use PCLab\Contracts\BraintreeServiceContract;
use PCLab\Services\BraintreeService;

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
