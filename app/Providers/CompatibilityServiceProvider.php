<?php

namespace PCForge\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PCForge\Compatibility\Comparators\ChassisChassisComparator;
use PCForge\Compatibility\Comparators\ChassisCoolingComparator;
use PCForge\Compatibility\Comparators\ChassisGraphicsComparator;
use PCForge\Compatibility\Comparators\ChassisMotherboardComparator;
use PCForge\Compatibility\Comparators\ChassisPowerComparator;
use PCForge\Compatibility\Comparators\ChassisStorageComparator;
use PCForge\Compatibility\Comparators\CoolingCoolingComparator;
use PCForge\Compatibility\Comparators\CoolingMemoryComparator;
use PCForge\Compatibility\Comparators\CoolingMotherboardComparator;
use PCForge\Compatibility\Comparators\CoolingPowerComparator;
use PCForge\Compatibility\Comparators\CoolingProcessorComparator;
use PCForge\Compatibility\Comparators\GraphicsGraphicsComparator;
use PCForge\Compatibility\Comparators\GraphicsMotherboardComparator;
use PCForge\Compatibility\Comparators\GraphicsPowerComparator;
use PCForge\Compatibility\Comparators\MemoryMemoryComparator;
use PCForge\Compatibility\Comparators\MemoryMotherboardComparator;
use PCForge\Compatibility\Comparators\MemoryPowerComparator;
use PCForge\Compatibility\Comparators\MotherboardMotherboardComparator;
use PCForge\Compatibility\Comparators\MotherboardPowerComparator;
use PCForge\Compatibility\Comparators\MotherboardProcessorComparator;
use PCForge\Compatibility\Comparators\MotherboardStorageComparator;
use PCForge\Compatibility\Comparators\PowerPowerComparator;
use PCForge\Compatibility\Comparators\PowerProcessorComparator;
use PCForge\Compatibility\Comparators\PowerStorageComparator;
use PCForge\Compatibility\Comparators\ProcessorProcessorComparator;
use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\Services\ComponentIncompatibilityService;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\SelectionContract;
use PCForge\Contracts\SelectionStorageServiceContract;
use PCForge\Contracts\SystemContract;

class CompatibilityServiceProvider extends ServiceProvider
{
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
        $this->app->singleton(SelectionContract::class, function (Application $app) {
            return $app->make(SelectionStorageServiceContract::class)->retrieve();
        });

        $this->app->singleton(
            SystemContract::class,
            System::class);

        $this->app->bind(
            ComponentIncompatibilityServiceContract::class,
            ComponentIncompatibilityService::class
        );

        $this->app->tag([
            ChassisChassisComparator::class,
            ChassisCoolingComparator::class,
            ChassisGraphicsComparator::class,
            ChassisMotherboardComparator::class,
            ChassisPowerComparator::class,
            ChassisStorageComparator::class,
            CoolingCoolingComparator::class,
            CoolingMemoryComparator::class,
            CoolingMotherboardComparator::class,
            CoolingPowerComparator::class,
            CoolingProcessorComparator::class,
            GraphicsGraphicsComparator::class,
            GraphicsMotherboardComparator::class,
            GraphicsPowerComparator::class,
            MemoryMemoryComparator::class,
            MemoryMotherboardComparator::class,
            MemoryPowerComparator::class,
            MotherboardMotherboardComparator::class,
            MotherboardPowerComparator::class,
            MotherboardProcessorComparator::class,
            MotherboardStorageComparator::class,
            PowerPowerComparator::class,
            PowerProcessorComparator::class,
            PowerStorageComparator::class,
            ProcessorProcessorComparator::class,
        ], 'comparators');

        $this->app->when(ComponentIncompatibilityService::class)
            ->needs('$comparators')
            ->give(function (Application $app) {
                return $app->tagged('comparators');
            });
    }
}
