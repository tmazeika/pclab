<?php

namespace PCLab\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use PCLab\Models\ChassisComponent;
use PCLab\Models\CoolingComponent;
use PCLab\Models\GraphicsComponent;
use PCLab\Models\MemoryComponent;
use PCLab\Models\MotherboardComponent;
use PCLab\Models\PowerComponent;
use PCLab\Models\ProcessorComponent;
use PCLab\Models\StorageComponent;

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
