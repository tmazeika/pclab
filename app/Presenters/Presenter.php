<?php

namespace PCForge\Presenters;

use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
    /** @var Model $entity */
    protected $entity;

    public function __construct(Model $entity)
    {
        $this->entity = $entity;
    }
}
