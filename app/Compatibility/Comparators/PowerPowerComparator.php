<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Models\PowerComponent;

class PowerPowerComparator implements IncompatibilityComparator
{
    /**
     * @param PowerComponent $power1
     * @param PowerComponent $power2
     *
     * @return bool
     */
    public function isIncompatible($power1, $power2): bool
    {
        return $power1->id !== $power2->id;
    }
}