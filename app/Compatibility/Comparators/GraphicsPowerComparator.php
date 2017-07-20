<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\PowerComponent;

class GraphicsPowerComparator implements IncompatibilityComparator
{
    // graphics
    public $with0 = [
        'parent',
    ];

    // power
    public $select1 = [
        'watts_out',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * @param GraphicsComponent $graphics
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($graphics, $power): bool
    {
        return !$this->system->hasEnoughPower($graphics, $power);
    }
}
