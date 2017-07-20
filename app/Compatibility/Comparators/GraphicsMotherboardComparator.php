<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\Selection;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;

class GraphicsMotherboardComparator implements IncompatibilityComparator
{
    // motherboard
    public $select1 = [
        'pcie3_slots',
    ];

    /** @var Selection $selection */
    private $selection;

    public function __construct(Selection $selection)
    {
        $this->selection = $selection;
    }

    /**
     * @param GraphicsComponent $graphics
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($graphics, $motherboard): bool
    {
        return $this->selection->getAllOfType(get_class($graphics))->count() === $motherboard->pcie3_slots;
    }
}
