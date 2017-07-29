<?php

namespace PCForge\Compatibility\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Models\ComponentChild;

class ComponentRepository implements ComponentRepositoryContract
{
    public function get(bool $filterAvailable = true): Collection
    {
        /** @var Collection $repo */
        $repo = cache()->rememberForever('component_repository', function () {
            return $this->getAllComponents();
        });

        return $repo->when($filterAvailable, function (Collection $collection) {
            return $collection->filter(function (ComponentChild $component) {
                return $component->parent->is_available;
            });
        });
    }

    private function getAllComponents(): Collection
    {
        $result = collect();

        foreach (Relation::morphMap() as $componentClass) {
            $result->push($componentClass::withAll()->get());
        }

        return $result->flatten();
    }
}
