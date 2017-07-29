<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Models\PowerComponent;
use PCForge\Models\StorageComponent;

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

    public function getComponents(): array
    {
        return ['power', 'storage'];
    }
}
