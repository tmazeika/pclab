<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class MemoryMotherboardComparator implements IncompatibilityComparator
{
    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(SelectionContract $selection)
    {
        $this->selection = $selection;
    }

    /**
     * @param MemoryComponent $memory
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($memory, $motherboard): bool
    {
        $selectedMemory = $this->selection->getAllOfType(get_class($memory));

        $memoryCount = $selectedMemory->sum(function (MemoryComponent $component) {
            return $component->count;
        });

        $memoryCapacity = $selectedMemory->sum(function (MemoryComponent $component) {
            return $component->count * $component->capacity_each;
        });

        return $memory->ddr_gen !== $motherboard->dimm_gen
            || $memory->pins !== $motherboard->dimm_pins
            || $memoryCount + $memory->count > $motherboard->dimm_slots
            || $memoryCapacity + $memory->count * $memory->capacity_each > $motherboard->dimm_max_capacity;
    }
}