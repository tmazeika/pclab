<?php

namespace PCForge\Compatibility\Helpers;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

class Selection
{
    /** @var Collection $components */
    private $components;

    public function select(ComponentChild $component): void
    {
        // set to 1 if not already set
        $component->selectCount = $component->selectCount ?: 1;

        $this->components->push($component);
    }

    public function deselect(ComponentChild $component): void
    {
        $component->selectCount = 0;

        // remove components that aren't selected
        $this->components = $this->components
            ->reject(function (ComponentChild $component) {
                return $component->selectCount === 0;
            });
    }

    public function getAllOfType(string $class): Collection
    {
        return $this->components
            ->filter(function (ComponentChild $component) use ($class) {
                return get_class($component) === $class;
            });
    }

    public function getAll(): Collection
    {
        return $this->components;
    }
}
