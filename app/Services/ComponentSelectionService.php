<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;
use PCForge\Models\ComponentType;

class ComponentSelectionService implements ComponentSelectionServiceContract
{
    public function select(ComponentChild $component, int $count): void
    {
        if ($count > 0) {
            session(["selected.$component->component_id" => $count]);
        } else {
            session()->forget("selected.$component->component_id");
        }
    }

    public function getCount(ComponentChild $component): int
    {
        return session("selected.$component->component_id", 0);
    }

    public function isSelected(ComponentChild $component): bool
    {
        return $this->getCount($component) > 0;
    }

    public function allSelected(array $select = ['*'], string $type = ''): Collection
    {
        return $this->applyQuerySelectAndType($select, $type, Component::whereIn('id', $this->getSelected()->keys()))->get();
    }

    public function all(array $select = ['*'], string $type = ''): Collection
    {
        $selected = $this->getSelected();

        return $this->applyQuerySelectAndType($select, $type, Component::whereIn('id', $selected->keys()))
            ->get()
            ->each(function (Component $component) use ($selected) {
                $component->count = $selected->get($component->id);
            });
    }

    private function getSelected(): Collection
    {
        return collect(session('selected', []));
    }

    private function applyQuerySelectAndType(array $select, string $type, $query)
    {
        if (count($select) > 0 && $select[0] !== '*') {
            $query->select($select);
        }

        if ($type !== '') {
            $query->where('component_type_id', ComponentType::select('id')->where('name', $type)->first()->id);
        }

        return $query;
    }
}
