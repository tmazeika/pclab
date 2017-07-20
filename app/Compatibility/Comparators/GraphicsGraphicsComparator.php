<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\GraphicsComponent;

class GraphicsGraphicsComparator implements IncompatibilityComparator
{
    // graphics0
    public $select0 = [
        'id',
    ];

    // graphics1
    public $select1 = [
        'id',
    ];

    /**
     * @param GraphicsComponent $graphics0
     * @param GraphicsComponent $graphics1
     *
     * @return bool
     */
    public function isIncompatible($graphics0, $graphics1): bool
    {
        return $graphics0->id !== $graphics1->id;
    }
}
