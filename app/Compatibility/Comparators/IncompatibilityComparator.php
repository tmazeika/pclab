<?php

namespace PCForge\Compatibility;

interface IncompatibilityComparator
{
    /**
     * Gets whether or not both given components are incompatible with each
     * other. A return value of false does not mean that the components are
     * necessarily "compatible".
     *
     * @param $component1
     * @param $component2
     *
     * @return bool
     */
    public function isIncompatible($component1, $component2): bool;
}
