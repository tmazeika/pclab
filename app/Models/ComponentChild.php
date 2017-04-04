<?php

namespace PCForge\Models;

trait ComponentChild
{
    public function featuresView()
    {
        return 'partials.build.' . $this->type() . '-component';
    }

    public function parent()
    {
        return $this->belongsTo('PCForge\Models\Component', 'component_id', 'id');
    }

    public function compatibilities()
    {
        return $this->hasMany('PCForge\Models\Compatibility', 'component_1_id', 'id');
    }

    public function type()
    {
        return strtolower(substr(get_called_class(), 15, strpos(get_called_class(), 'Component') - 15));
    }
}
