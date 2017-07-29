<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;

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

    public function getComponents(): array
    {
        return ['graphics', 'motherboard'];
    }
}
