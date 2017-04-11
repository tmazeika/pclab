<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\AdjacencyMatrix;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\CompatibilityNode;
use PCForge\Models\Component;

class CompatibilityService implements CompatibilityServiceContract
{
    public const SELECTED_SESSION_KEY = 'selected';

    public const INCOMPATIBILITIES_SESSION_KEY = 'incompatibilities';

    public function isAllowed(int $id, int $count): bool
    {
        return !in_array($id, $this->getIncompatibilities(), true);
    }

    public function select(int $id, int $count): array
    {
        $selectedSessionKey = self::SELECTED_SESSION_KEY . ".$id";

        if ($count > 0) {
            session([$selectedSessionKey => $count]);
        } else {
            session()->forget($selectedSessionKey);
        }

        return $this->getIncompatibilities(true);
    }

    private function getIncompatibilities(bool $recompute = false): array
    {
        if (!$recompute) {
            return session(self::INCOMPATIBILITIES_SESSION_KEY, []);
        }

        /** @var Collection $components */
        // TODO: probably some other checks to make?
        $components = Component
            ::where('is_available', true)
            ->get();

        /** @var array $selected */
        $selected = session('selected', []);

        $compatibilities = [];
        $incompatibilities = [];

        foreach ($components as $component) {
            /** @var CompatibilityNode $node */
            $node = $component->toCompatibilityNode();

            /** @var int $key */
            $key = $component->id - 1;

            $incompatibilities[$key] = array_unique(array_merge(
                // static
                cache()->tags('static.incompatibilities')->rememberForever($key, function () use ($node) {
                    return $node->getStaticallyIncompatibleComponents();
                }),
                // dynamic
                $node->getDynamicallyIncompatibleComponents($selected)
            ));

            $compatibilities[$key] = array_diff(array_unique(array_merge(
                // static
                cache()->tags('static.compatibilities')->rememberForever($key, function () use ($node) {
                    return $node->getStaticallyCompatibleComponents();
                }),
                // dynamic
                $node->getDynamicallyCompatibleComponents($selected)
            )), $incompatibilities[$key]);
        }

        $computedCompatibilities = $this->computeCompatibilities($compatibilities, $incompatibilities);

        // gets all components and subtracts out all that are considered compatible with the current selection
        $computedIncompatibilities = empty($selected) ? [] : $components
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
                ->pipe(function (Collection $collection) {
                    return $collection->count() > 1
                        ? collect(array_intersect(...$collection->toArray()))
                        : $collection->flatten();
                })
                // map ID's to their ID's as represented in the session and the database
                ->map(function (int $id) {
                    return $id + 1;
                }))
            ->values()
            ->all();

        session([self::INCOMPATIBILITIES_SESSION_KEY => $computedIncompatibilities]);

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
     * @param array $compatibilities
     * @param array $incompatibilities
     *
     * @return array
     */
    private function computeCompatibilities(array $compatibilities, array $incompatibilities): array
    {
        $arr = [];

        $compatibilityAdjacencyMatrix = new AdjacencyMatrix(
            $this->zeroBaseAdjacentIds($compatibilities)
        );

        $incompatibilityAdjacencyMatrix = new AdjacencyMatrix(
            $this->zeroBaseAdjacentIds($incompatibilities)
        );

        // step 1
        foreach ($compatibilityAdjacencyMatrix as $node) {
            // clone for traversal and zeroing
            $compatAM = clone $compatibilityAdjacencyMatrix;

            // step 2
            foreach ($compatAM as $row) {
                if ($incompatibilityAdjacencyMatrix->hasEdgeAt($node, $row)) {
                    $compatAM->zeroNode($row);
                }
            }

            // step 3
            foreach ($compatAM->getAllReachableNodesFrom($node) as $compatNode) {
                $arr[$node][] = $compatNode;
            }
        }

        return $arr;
    }

    private function zeroBaseAdjacentIds(array $componentsToAdjacent): array
    {
        for ($i = 0; $i < count($componentsToAdjacent); $i++) {
            if (isset($componentsToAdjacent[$i])) {
                for ($j = 0; $j < count($componentsToAdjacent[$i]); $j++) {
                    if (isset($componentsToAdjacent[$i][$j])) {
                        $componentsToAdjacent[$i][$j]--;
                    }
                }
            }
        }

        return $componentsToAdjacent;
    }
}
