<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\Component;

class ComponentRepository implements ComponentRepositoryContract
{
    /** @var ComponentCompatibilityServiceContract $componentCompatibilityService */
    private $componentCompatibilityService;

    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentCompatibilityServiceContract $componentCompatibilityService,
                                ComponentSelectionServiceContract $componentSelectionService)
    {
        $this->componentCompatibilityService = $componentCompatibilityService;
        $this->componentSelectionService = $componentSelectionService;
    }

    public function buildGroupedReachable(): Collection
    {
        return $this->computeReachable()
            ->groupBy('component_type_id')
            ->sortBy(function ($value, int $key) {
                return $key;
            })
            ->map(function (Collection $components) {
                return $components->map(function (Component $component) {
                    return $component->child();
                });
            });
    }

    public function computeReachable($select = ['*']): Collection
    {
        return $this->applyQuerySelect($select, Component::whereNotIn('id', $this->computeUnreachable()->pluck('id')))->get();
    }

    public function computeUnreachable(): Collection
    {
        $unreachable = $this->componentCompatibilityService->computeIncompatibilities()
            ->union(Component::select('id')->where('is_available', false)->get());

        return $unreachable;
    }

    private function applyQuerySelect(array $select, $query)
    {
        if (count($select) > 0 && $select[0] !== '*') {
            $query->select($select);
        }

        return $query;
    }
}
