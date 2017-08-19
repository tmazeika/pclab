<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Models\GraphicsComponent;
use PCLab\Models\MotherboardComponent;

class GraphicsMotherboardComparator implements IncompatibilityComparator
{
    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(SelectionContract $selection)
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