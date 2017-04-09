<?php

namespace PCForge\Models;

trait ComponentChild
{
    public static function featuresView()
    {
        return 'partials.build.' . self::typeName() . '-component';
    }

    public static function typeName()
    {
        // e.g. 'PCForge\Models\ProcessorComponent' -> 'processor'
        return strtolower(substr(class_basename(get_called_class()), 0, -strlen('Component')));
    }

    public function compatibilities()
    {
        return $this->hasMany('PCForge\Models\Compatibility', 'component_1_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('PCForge\Models\Component', 'component_id', 'id');
    }
}
