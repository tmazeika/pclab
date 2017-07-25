<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;

use PCForge\Contracts\SystemContract;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\PowerComponent;

class GraphicsPowerComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
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

    public function getComponents(): array
    {
        return ['graphics', 'power'];
    }
}
