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
        return $this->componentSelectionService->getCount($this->entity->id);
    }

    public function selectedClass(): string
    {
        if ($this->componentSelectionService->isSelected($this->entity->id)) {
            return 'selected';
        }

        return '';
    }

    public function disabledClass(): string
    {
        return '';

        //if ($this->componentDisabledService->isDisabled($this->entity)) {
        //    return 'disabled';
        //}
        //
        //return '';
    }
}
