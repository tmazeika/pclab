<?php

namespace PCForge;

trait ComponentChild
{
    public function component()
    {
        return $this->belongsTo('PCForge\Component');
    }
}
