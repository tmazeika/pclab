<?php

namespace PCForge\Presenters;

use PCForge\Contracts\ComponentDisabledServiceContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\PCForgeModel;

trait ComponentPresenterTrait
{
    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    /** @var ComponentDisabledServiceContract $componentDisabledService */
    private $componentDisabledService;

    public function __construct(ComponentSelectionServiceContract $componentSelectionService,
                                ComponentDisabledServiceContract $componentDisabledService, PCForgeModel $entity)
    {
        /** @noinspection PhpUndefinedClassInspection */
        parent::__construct($entity);

        $this->componentSelectionService = $componentSelectionService;
        $this->componentDisabledService = $componentDisabledService;
    }

    public function selectedClass(): string
    {
        if ($this->componentSelectionService->isSelected($this->entity)) {
            return 'selected';
        }

        return '';
    }

    public function disabledClass(): string
    {
        if ($this->componentDisabledService->isDisabled($this->entity)) {
            return 'disabled';
        }

        return '';
    }
}
