<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Models\PowerComponent;
use PCLab\Models\StorageComponent;

class PowerStorageComparator implements IncompatibilityComparator
{
    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(SelectionContract $selection)
    {
        $this->selection = $selection;
    }

    /**
     * @param PowerComponent $power
     * @param StorageComponent $storage
     *
     * @return bool
     */
    public function isIncompatible($power, $storage): bool
    {
        return $this->selection->getAllOfType(get_class($storage))->count() === $power->sata_powers;
    }
}