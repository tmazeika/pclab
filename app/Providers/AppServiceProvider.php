<?php

namespace PCLab\Providers;

use Illuminate\Support\ServiceProvider;
use PCLab\Contracts\StripeServiceContract;
use PCLab\Services\StripeService;

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
            StripeServiceContract::class,
            StripeService::class
        );
    }
}
