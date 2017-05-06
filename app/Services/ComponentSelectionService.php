<?php

namespace PCForge\Services;

use PCForge\Contracts\ComponentSelectionServiceContract;

class ComponentSelectionService implements ComponentSelectionServiceContract
{
    public function select(int $id, int $count): void
    {
        if ($count > 0) {
            session(["selected.$id" => $count]);
        } else {
            session()->forget("selected.$id");
        }
    }

    public function isSelected(int $id): bool
    {
        return $this->getCount($id) > 0;
    }

    public function getCount(int $id): int
    {
        return session("selected.$id", 0);
    }

    public function selection(): array
    {
        return session('selected', []);
    }
}
