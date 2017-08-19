<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\GraphicsComponent;
use PCLab\Models\PowerComponent;

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
}