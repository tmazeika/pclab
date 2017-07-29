<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\GraphicsComponent;

class GraphicsGraphicsComparator implements IncompatibilityComparator
{
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

    public function getComponents(): array
    {
        return ['graphics', 'graphics'];
    }
}
