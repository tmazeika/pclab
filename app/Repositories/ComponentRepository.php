<?php

namespace PCForge\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;

class ComponentRepository implements ComponentRepositoryContract
{
    public function get(bool $available, array $selects, array $withs): Collection
    {
        $results = collect();

        foreach ($selects as $type => $values) {
            $columns = array_map(function ($column) use ($type) {
                return "${type}_components.$column";
            }, $selects[$type]);
            $mappedWiths = array_map(function ($columns) {
                return function (Builder $query) use ($columns) {
                    $query->select($columns);
                };
            }, $withs[$type]);

            $model = '\PCForge\Models\\' . ucfirst($type) . 'Component';

            $results->put($type, $model::select($columns)
                ->with($mappedWiths)
                ->whereHas('parent', function (Builder $query) use ($available) {
                    if ($available) {
                        $query->where('is_available', true);
                    }
                })
                ->get()
            );
        }

        return $results;
    }
}
