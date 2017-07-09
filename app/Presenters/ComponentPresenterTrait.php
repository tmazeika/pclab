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
        /** @noinspection PhpUndefinedClassInspection */
        parent::__construct($entity);

        $this->componentSelectionService = $componentSelectionService;
    }

    public function count(): int
    {
        return $this->componentSelectionService->getCount($this->entity->parent->id);
    }

    public function selectedClass(): string
    {
        return $this->componentSelectionService->isSelected($this->entity->parent->id) ? 'selected' : '';
    }

    public function disabledClass(): string
    {
        return $this->entity->disabled ? 'disabled' : '';
    }
}
