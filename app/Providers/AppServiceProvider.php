<?php

namespace PCForge\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            'PCForge\Contracts\CompatibilityServiceContract',
            'PCForge\Services\CompatibilityService'
        );
    }
}
