<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Models\ComponentChild;
use PCLab\Models\MotherboardComponent;
use PCLab\Models\StorageComponent;

class MotherboardStorageComparator implements IncompatibilityComparator
{
    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(SelectionContract $selection)
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
        $storageCount = $this->selection->getAllOfType(get_class($storage))->sum(function (ComponentChild $component) {
            return $component->selectCount;
        });

        return $storageCount > $motherboard->sata_slots;
    }
}