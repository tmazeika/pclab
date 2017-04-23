<?php

namespace PCForge\Models;

abstract class ComponentChild extends PCForgeModel
{
    use HasPresenterTrait;

    public static function featuresView()
    {
        return 'partials.build.' . self::typeName() . '-component';
    }

    public static function typeName()
    {
        // e.g. 'PCForge\Models\ProcessorComponent' -> 'processor'
        return strtolower(substr(class_basename(get_called_class()), 0, -strlen('Component')));
    }

    public function parent()
    {
        return $this->morphOne(Component::class, 'child');
    }
}
