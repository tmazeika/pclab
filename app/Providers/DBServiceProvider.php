<?php

namespace PCForge\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;
use PCForge\Models\StorageComponent;

class DBServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'chassis'     => ChassisComponent::class,
            'cooling'     => CoolingComponent::class,
            'graphics'    => GraphicsComponent::class,
            'memory'      => MemoryComponent::class,
            'motherboard' => MotherboardComponent::class,
            'power'       => PowerComponent::class,
            'processor'   => ProcessorComponent::class,
            'storage'     => StorageComponent::class,
        ]);

        //$i = 1;
        //
        //DB::listen(function($sql) use (&$i) {
        //    echo $i++ . ':';
        //    var_dump($i.': '.$sql->sql);
        //    var_dump($sql->bindings);
        //});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
