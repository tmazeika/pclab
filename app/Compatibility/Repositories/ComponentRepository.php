<?php

namespace PCForge\Compatibility\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Models\ComponentChild;

class ComponentRepository implements ComponentRepositoryContract
{
    public function get(): Collection
    {
        static $cached;

        /** @var Collection $repo */
        return $cached ?? ($cached = cache()->rememberForever('component_repository', function () {
            return $this->getAllComponents();
        }));
    }

    public function find(int $id): ComponentChild
    {
        return $this->get()->where('parent.id', $id)->first();
    }

    /**
     * Gets a collection of all components from the database, selecting all columns and relations.
     *
     * @return Collection
     */
    private function getAllComponents(): Collection
    {
        $result = collect();

        foreach (Relation::morphMap() as $componentClass) {
            $result->push($componentClass::withAll()->get());
        }

        return $result->flatten();
    }
}
