<?php

namespace PCLab\Presenters;

use Illuminate\Database\Eloquent\Model;
use PCLab\Compatibility\Contracts\SelectionContract;

trait ComponentPresenterTrait
{
    /** @var SelectionContract $selection */
    protected $selection;

    public function __construct(Model $entity, SelectionContract $selection)
    {
        /** @noinspection PhpParamsInspection, PhpUndefinedClassInspection */
        parent::__construct($entity);

        $this->selection = $selection;
    }

    public function count(): int
    {
        return $this->entity->selectCount;
    }

    public function selectedClass(): string
    {
        return ($this->count() > 0) ? 'selected' : '';
    }

    public function disabledClass(): string
    {
        return $this->entity->disabled ? 'disabled' : '';
    }
}
