<?php

namespace PCForge\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ComponentChild;

class ComponentRepository implements ComponentRepositoryContract
{
    public function get(bool $onlyAvailable): Collection
    {
        /** @var Collection $repo */
        $repo = cache()->rememberForever('component_repository', function () {
            $result = collect();

            foreach (Relation::morphMap() as $componentClass) {
                $result->push($componentClass::withAll()->get());
            }

            return $result->flatten();
        });

        return $repo->when($onlyAvailable, function (Collection $collection) {
            return $collection->filter(function (ComponentChild $component) {
                return $component->parent->is_available;
            });
        });
    }
}
