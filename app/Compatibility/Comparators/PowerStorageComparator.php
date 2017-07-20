<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\Selection;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\PowerComponent;
use PCForge\Models\StorageComponent;

class PowerStorageComparator implements IncompatibilityComparator
{
    // power
    public $select0 = [
        'sata_powers',
    ];

    /** @var Selection $selection */
    private $selection;

    public function __construct(Selection $selection)
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
