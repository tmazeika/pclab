<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\Selection;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\StorageComponent;

class MotherboardStorageComparator implements IncompatibilityComparator
{
    // motherboard
    public $select0 = [
        'sata_slots',
    ];

    /** @var Selection $selection */
    private $selection;

    public function __construct(Selection $selection)
    {
        $this->selection = $selection;
    }

    /**
     * @param MotherboardComponent $motherboard
     * @param StorageComponent $storage
     *
     * @return bool
     */
    public function isIncompatible($motherboard, $storage): bool
    {
        return $motherboard->sata_slots < $this->selection->getAllOfType(get_class($storage))->count();
    }
}
