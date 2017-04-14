<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\AdjacencyMatrix;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionRepositoryContract;
use PCForge\Models\ComponentChild;

class CompatibilityService implements CompatibilityServiceContract
{
    /** @var ComponentSelectionRepositoryContract $componentSelectionRepo */
    private $componentSelectionRepo;

    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    public function __construct(ComponentSelectionRepositoryContract $componentSelectionRepo,
                                ComponentRepositoryContract $componentRepo)
    {
        $this->componentSelectionRepo = $componentSelectionRepo;
        $this->componentRepo = $componentRepo;
    }

    public function select(int $id, int $count): Collection
    {
        if ($this->computeIncompatibilities()->contains($id)) {
            abort(400, 'Component Not Selectable');
        }

        $this->componentSelectionRepo->select($id, $count);

        return $this->computeIncompatibilities(true);
    }

    public function isUnavailable(int $id): bool
    {
        return cache()->tags(['components', 'incompatibilities'])->rememberForever('empty', function () {
            $components = $this->componentRepo->all();

            return $components
                ->pluck('id')
                ->diff(collect($this->computeCompatibilities([]))
                    ->keys()
                    ->map(function (int $id) {
                        return $id + 1;
                    }))
                ->merge($components
                    ->where('is_available', false)
                    ->pluck('id'));
        })->contains($id);
    }

    private function computeIncompatibilities(bool $recompute = false): Collection
    {
        if (!$recompute) {
            return collect(session('incompatibilities', []));
        }

        $selected = $this->componentSelectionRepo->all();
        $computedCompatibilities = $this->computeCompatibilities($selected);

        // gets all components and subtracts out all that are considered compatible with the current selection
        $computedIncompatibilities = empty($selected)
            ? collect()
            : $this->componentRepo->all()
                ->pluck('id')
                ->diff(collect($selected)
                    // get just the ID's
                    ->keys()
                    // map ID's to an array of their adjacent ID's
                    ->map(function (int $id) use ($computedCompatibilities) {
                        return $computedCompatibilities[$id - 1] ?? [];
                    })
                    // don't include empty adjacency arrays
                    ->reject(function (array $adjacent) {
                        return empty($adjacent);
                    })
                    // get intersection of all adjacency arrays
                    ->reduce(function ($carry, array $adjacent) {
                        return $carry
                            ? $carry->intersect($adjacent)
                            : collect($adjacent);
                    })
                    // map ID's to their ID's as represented in the session and the database
                    ->map(function (int $id) {
                        return $id + 1;
                    }))
                ->values();

        session(['incompatibilities' => $computedIncompatibilities->toArray()]);

        return $computedIncompatibilities;
    }

    /**
     * Procedure:
     * 1. Pick a component
     * 2. In the compatibility adjacency matrix, zero the rows and columns that have an edge in the picked component's
     *    incompatibility adjacency matrix column
     * 3. Mark all reachable components from the picked component's compatibility adjacency matrix column as
     *    'compatible'
     *
     * @param array $selected
     *
     * @return array
     */
    private function computeCompatibilities(array $selected): array
    {
        /** @var Collection $components */
        $components = $this->componentRepo->all();

        // build compatibility and incompatibility arrays
        foreach ($components as $component) {
            /** @var int $key */
            $key = $component->id - 1;

            /** @var ComponentChild $compatNode */
            $compatNode = $component->child();

            $incompatibilities[$key] =
                cache()->tags(['components', 'incompatibilities'])->rememberForever($key, function () use ($compatNode) {
                    return $compatNode->getStaticallyIncompatibleComponents();
                })
                    ->merge($compatNode->getDynamicallyIncompatibleComponents($selected))
                    ->unique()
                    ->map(function (int $id) {
                        return $id - 1;
                    })
                    ->when(!$component->is_available, function () {
                        return collect();
                    })
                    ->toArray();

            $compatibilities[$key] =
                cache()->tags(['components', 'compatibilities'])->rememberForever($key, function () use ($compatNode) {
                    return $compatNode->getStaticallyCompatibleComponents();
                })
                    ->merge($compatNode->getDynamicallyCompatibleComponents($selected))
                    ->unique()
                    ->map(function (int $id) {
                        return $id - 1;
                    })
                    ->diff($incompatibilities[$key])
                    ->when(!$component->is_available, function () {
                        return collect();
                    })
                    ->toArray();
        }

        // build adjacency matrices
        $compatibilitiesAdjacencyMatrix = new AdjacencyMatrix($compatibilities ?? []);
        $incompatibilitiesAdjacencyMatrix = new AdjacencyMatrix($incompatibilities ?? []);

        // step 1
        foreach ($compatibilitiesAdjacencyMatrix as $node) {
            // clone for traversal and zeroing
            $compatAM = clone $compatibilitiesAdjacencyMatrix;

            // step 2
            foreach ($compatAM as $row) {
                if ($incompatibilitiesAdjacencyMatrix->hasEdgeAt($node, $row)) {
                    $compatAM->zeroNode($row);
                }
            }

            // step 3
            foreach ($compatAM->getAllReachableNodesFrom($node) as $compatNode) {
                $arr[$node][] = $compatNode;
            }
        }

        return $arr ?? [];
    }
}
