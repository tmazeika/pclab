<?php

namespace PCForge;

trait ComponentChild
{
    public function featuresView()
    {
        return 'partials.build.'.$this->type().'-component';
    }

    public function component()
    {
        return $this->belongsTo('PCForge\Component');
    }

    public function type()
    {
        return strtolower(substr(get_called_class(), 8, strpos(get_called_class(), 'Component') - 8));
    }
}
