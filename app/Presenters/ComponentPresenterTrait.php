<?php

namespace PCForge\Presenters;

use Illuminate\Database\Eloquent\Model;

trait ComponentPresenterTrait
{
    public function __construct($componentSelectionService, Model $entity)
    {
        /** @noinspection PhpParamsInspection, PhpUndefinedClassInspection */
        parent::__construct($entity);
    }

    public function count(): int
    {
        return $this->entity->selectCount;
    }

    public function selectedClass(): string
    {
        return ($this->entity->selectCount > 0) ? 'selected' : '';
    }

    public function disabledClass(): string
    {
        return $this->entity->disabled ? 'disabled' : '';
    }
}
