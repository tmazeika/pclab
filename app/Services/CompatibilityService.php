<?php

namespace PCForge\Services;

use PCForge\Contracts\CompatibilityServiceContract;

class CompatibilityService implements CompatibilityServiceContract
{
    public function isAllowedToSelect(int $componentId): bool
    {
        // TODO: check if disabled
        return !session("$componentId.selected");
    }

    public function select(int $componentId, string $componentType): array
    {
        return [6, 15];
    }

    public function deselect(int $componentId, string $componentType): array
    {
        return [6, 15];
    }
}
