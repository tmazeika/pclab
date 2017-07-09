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
        $component->selectCount = $component->selectCount ?: 1;

        $this->components->push($component);
    }

    public function deselect(ComponentChild $component): void
    {
        $component->selectCount = 0;

        $this->components = $this->components->reject(function (ComponentChild $component) {
            return $component->selectCount === 0;
        });
    }

    public function getAllOfType(string $class): Collection
    {
        return $this->components->filter(function (ComponentChild $component) use ($class) {
            return get_class($component) === $class;
        });
    }

    public function getAll(): Collection
    {
        return $this->components;
    }

    public function setAll(Collection $components): void
    {
        $this->components = $components;
    }
}
