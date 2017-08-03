<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\MotherboardComponent;

class MotherboardMotherboardComparator implements IncompatibilityComparator
{
    /**
     * @param MotherboardComponent $motherboard1
     * @param MotherboardComponent $motherboard2
     *
     * @return bool
     */
    public function isIncompatible($motherboard1, $motherboard2): bool
    {
        return $motherboard1->id !== $motherboard2->id;
    }
}