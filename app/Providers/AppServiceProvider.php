<?php

namespace PCForge\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use PCForge\Compatibility\ChassisComponentCompatibilityProvider;
use PCForge\Compatibility\CoolingComponentCompatibilityProvider;
use PCForge\Compatibility\GraphicsComponentCompatibilityProvider;
use PCForge\Compatibility\MemoryComponentCompatibilityProvider;
use PCForge\Compatibility\MotherboardComponentCompatibilityProvider;
use PCForge\Compatibility\PowerComponentCompatibilityProvider;
use PCForge\Compatibility\ProcessorComponentCompatibilityProvider;
use PCForge\Compatibility\StorageComponentCompatibilityProvider;
use PCForge\Contracts\BraintreeServiceContract;
use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentDisabledServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Repositories\ComponentRepository;
use PCForge\Repositories\ComponentSelectionService;
use PCForge\Services\BraintreeService;
use PCForge\Services\ComponentCompatibilityService;
use PCForge\Services\ComponentDisabledService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('active', function ($page) {
            $page = addslashes($page);

            return "<?php if ((\$active ?? '') === '$page') echo 'active'; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // contracts
        $this->app->singleton(
            ComponentCompatibilityServiceContract::class,
            ComponentCompatibilityService::class
        );

        $this->app->singleton(
            BraintreeServiceContract::class,
            BraintreeService::class
        );

        $this->app->singleton(
            ComponentDisabledServiceContract::class,
            ComponentDisabledService::class
        );

        $this->app->bind(
            ComponentSelectionServiceContract::class,
            ComponentSelectionService::class
        );

        $this->app->singleton(
            ComponentRepositoryContract::class,
            ComponentRepository::class
        );

        // compatibility providers
        //$this->app->bind(ChassisComponentCompatibilityProvider::class);
        //$this->app->bind(CoolingComponentCompatibilityProvider::class);
        //$this->app->bind(GraphicsComponentCompatibilityProvider::class);
        //$this->app->bind(MemoryComponentCompatibilityProvider::class);
        //$this->app->bind(MotherboardComponentCompatibilityProvider::class);
        //$this->app->bind(PowerComponentCompatibilityProvider::class);
        //$this->app->bind(ProcessorComponentCompatibilityProvider::class);
        //$this->app->bind(StorageComponentCompatibilityProvider::class);

        $this->app->tag([
            ChassisComponentCompatibilityProvider::class,
            CoolingComponentCompatibilityProvider::class,
            GraphicsComponentCompatibilityProvider::class,
            MemoryComponentCompatibilityProvider::class,
            MotherboardComponentCompatibilityProvider::class,
            PowerComponentCompatibilityProvider::class,
            ProcessorComponentCompatibilityProvider::class,
            StorageComponentCompatibilityProvider::class,
        ], 'compatibility-providers');

        $this->app->bind(ComponentCompatibilityServiceContract::class, function (Application $app) {
            return $app->makeWith(ComponentCompatibilityService::class, [
                'compatibilityProviders' => $app->tagged('compatibility-providers'),
            ]);
        });
    }
}
