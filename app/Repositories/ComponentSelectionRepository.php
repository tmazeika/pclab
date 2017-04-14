<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentSelectionRepositoryContract;

class ComponentSelectionRepository implements ComponentSelectionRepositoryContract
{
    public function select(int $id, int $count): void
    {
        if ($count > 0) {
            session(["selected.$id" => $count]);
        } else {
            session()->forget("selected.$id");
        }
    }

    public function getSelectionCount(int $id): int
    {
        return session("selected.$id", 0);
    }

    public function isSelected(int $id): bool
    {
        return $this->getSelectionCount($id) > 0;
    }

    public function all(): array
    {
        return session("selected", []);
    }
}
