<?php

namespace PCForge;

trait ComponentChild
{
    public function featuresView()
    {
        return 'partials.build.'.$this->type().'-component';
    }

    public function parent()
    {
        return $this->belongsTo('PCForge\Component', 'component_id', 'id');
    }

    public function type()
    {
        return strtolower(substr(get_called_class(), 8, strpos(get_called_class(), 'Component') - 8));
    }
}
