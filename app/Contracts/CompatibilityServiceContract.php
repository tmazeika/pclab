<?php

namespace PCForge\Contracts;

interface CompatibilityServiceContract
{
    /**
     * @param int $id
     * @param int $count
     *
     * @return bool whether or not the given component is allowed to be selected
     */
    public function isAllowed(int $id, int $count): bool;

    /**
     * Selects the given component the given amount of times. A full compatibility check will be run to determine which
     * other components will not be compatible with the given one. If $count is 0, the returned ID's are those that are
     * now compatible with the given component.
     *
     * @param int $id
     * @param int $count
     *
     * @return int[] the other component ID's that are to be marked as incompatible with the given component, or
     * compatible if $count is 0
     */
    public function select(int $id, int $count): array;
}
