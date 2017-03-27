<?php

namespace PCForge\Contracts;

interface CompatibilityServiceContract
{
    /**
     * @param int $componentId
     *
     * @return bool whether or not the given component is allowed to be selected
     */
    public function isAllowedToSelect(int $componentId): bool;

    /**
     * Selects the given component. A full compatibility check will be run to determine which other components will not
     * be compatible with the given one.
     *
     * @param int $componentId
     * @param string $componentType
     *
     * @return int[] the other component ID's that are not compatible with the given component
     */
    public function select(int $componentId, string $componentType): array;

    /**
     * Deselects the given component. A list of component ID's that are now not to be deemed incompatible with the
     * build is returned.
     *
     * @param int $componentId
     * @param string $componentType
     *
     * @return int[] the other component ID's that now compatible with the build
     */
    public function deselect(int $componentId, string $componentType): array;
}
