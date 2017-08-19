<?php

namespace PCLab\Compatibility\Comparators;


use PCLab\Models\CoolingComponent;

class CoolingCoolingComparator implements IncompatibilityComparator
{
    /**
     * @param CoolingComponent $cooling1
     * @param CoolingComponent $cooling2
     *
     * @return bool
     */
    public function isIncompatible($cooling1, $cooling2): bool
    {
        return $cooling1->id !== $cooling2->id;
    }
}