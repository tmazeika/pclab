<?php

namespace PCForge\Presenters;

use Illuminate\Database\Eloquent\Model;
use PCForge\Contracts\ComponentSelectionServiceContract;

trait ComponentPresenterTrait
{
    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentSelectionServiceContract $componentSelectionService, Model $entity)
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
