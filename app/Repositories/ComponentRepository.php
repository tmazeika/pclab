<?php

namespace PCForge\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PCForge\Contracts\ComponentRepositoryContract;

class ComponentRepository implements ComponentRepositoryContract
{
    private $allCache = [];

    public function all(array $selects = ['*'], array $withs = []): Collection
    {
        $cacheKey = json_encode($selects) . json_encode($withs);

        if ($allCache = $this->allCache[$cacheKey]) {
            return $allCache;
        }

        $groupByTable = function (string $str) {
            $exploded = explode('.', $str, 2);

            return [$exploded[0] => $exploded[1]];
        };

        $groupedWiths = collect($withs)->mapToGroups($groupByTable);

        return $this->allCache[$cacheKey] = $this->qualifyAllSelector()
            ->merge($selects->mapToGroups($groupByTable))
            ->map(function (array $selects, string $table) use ($groupedWiths) {
                $withs = array_merge(['parent'], $groupedWiths[$table] ?? []); // TODO: simplify?

                return DB::table($table)->with($withs)->select($selects)->all();
            });
    }

    private function qualifyAllSelector(): Collection
    {
        return collect(Relation::morphMap())
            ->keys()
            ->mapWithKeys(function (string $type) {
                return [$type . '_components' => '*'];
            });
    }
}
