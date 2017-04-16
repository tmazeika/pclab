<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\ComponentChild;

class NullComponentSelectionService implements ComponentSelectionServiceContract
{
    public function select(ComponentChild $component, int $count): void
    {
        //
    }

    public function getCount(ComponentChild $component): int
    {
        return 0;
    }

    public function isSelected(ComponentChild $component): bool
    {
        return false;
    }

    public function allSelected(array $select = ['*'], string $type = ''): Collection
    {
        return collect();
    }

    public function all(array $select = ['*'], string $type = ''): Collection
    {
        return collect();
    }
}
