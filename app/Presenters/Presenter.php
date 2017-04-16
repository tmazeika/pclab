<?php

namespace PCForge\Presenters;

use PCForge\Models\PCForgeModel;

abstract class Presenter
{
    /** @var PCForgeModel $entity */
    protected $entity;

    public function __construct(PCForgeModel $entity)
    {
        $this->entity = $entity;
    }
}
