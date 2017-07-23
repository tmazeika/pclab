<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\GraphicsComponent;

class GraphicsGraphicsComparator implements IncompatibilityComparator
{
    // graphics 1
    public $select1 = [
        'id',
    ];

    // graphics 2
    public $select2 = [
        'id',
    ];

    /**
     * @param GraphicsComponent $graphics1
     * @param GraphicsComponent $graphics2
     *
     * @return bool
     */
    public function isIncompatible($graphics1, $graphics2): bool
    {
        return $graphics1->id !== $graphics2->id;
    }
}
