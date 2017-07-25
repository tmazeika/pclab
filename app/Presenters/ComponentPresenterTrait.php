<?php

namespace PCForge\Presenters;

use Illuminate\Database\Eloquent\Model;
use PCForge\Contracts\SelectionStorageServiceContract;

trait ComponentPresenterTrait
{
    /** @var SelectionStorageServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(SelectionStorageServiceContract $componentSelectionService, Model $entity)
    {
        /** @noinspection PhpParamsInspection, PhpUndefinedClassInspection */
        parent::__construct($entity);

        $this->componentSelectionService = $componentSelectionService;
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
