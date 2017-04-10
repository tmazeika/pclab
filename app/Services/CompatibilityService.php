<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\AdjacencyMatrix;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\CompatibilityNode;
use PCForge\Models\Component;

class CompatibilityService implements CompatibilityServiceContract
{
    public function isAllowed(int $id, int $count): bool
    {
        return !$this->isDisabled($id);
    }

    public function select(int $id, int $count): array
    {
        session(["c$id-selected-count" => $count]);

        if ($count === 0) {
            session()->forget("selected.$id");
        } else if (!session()->exists("selected.$id")) {
            session()->push('selected', $id);
        }

        /** @var array $selected */
        $selected = session()->get('selected', []);

        /** @var Collection $components */
        $components = Component::where('is_available', true)->get();

        return collect($this->getIncompatibilities($components, $id, $selected))
            ->map(function (int $incompatId) {
                return $incompatId + 1;
            })
            ->filter(function (int $incompatId) use ($id, $count) {
                /** @var array $disabledFrom */
                $disabledFrom = session("c$incompatId-disabled-from", []);

                /** @var bool $disabledFromId */
                $disabledFromId = in_array($id, $disabledFrom);

                // if we're not deselecting and this component hasn't already been disabled by the selected component...
                if ($count > 0 && !$disabledFromId) {
                    session()->push("c$incompatId-disabled-from", $id);

                    return true;
                }

                // if we're deselecting and this component has previously been disabled by the selected component...
                if ($count === 0 && $disabledFromId && ($key = array_search($id, $disabledFrom, true)) !== false) {
                    session()->forget("c$incompatId-disabled-from.$key");

                    return !$this->isDisabled($incompatId);
                }

                return false;
            })
            ->values()
            ->all();
    }

    private function getIncompatibilities(Collection $components, int $componentId, array $selected): array
    {
        $compatibilities = [];
        $incompatibilities = [];

        foreach ($components as $component) {
            /** @var CompatibilityNode $node */
            $node = $component->toCompatibilityNode();
            $key = $component->id - 1;

            $compatibilities[$key] = array_unique(array_merge(
                // static
                cache()->tags('static-compatibilities')->rememberForever("c$key", function () use ($node) {
                    return $node->getStaticallyCompatibleComponents();
                }),
                // dynamic
                $node->getDynamicallyCompatibleComponents($selected)
            ));

            $incompatibilities[$key] = array_unique(array_merge(
                // static
                cache()->tags('static-incompatibilities')->rememberForever("c$key", function () use ($node) {
                    return $node->getStaticallyIncompatibleComponents();
                }),
                // dynamic
                $node->getDynamicallyIncompatibleComponents($selected)
            ));
        }

        return $components
            ->map(function (Component $component) {
                return $component->id - 1;
            })
            ->diff($this->getCompatibilities($compatibilities, $incompatibilities)[$componentId - 1])
            ->toArray();
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
    private function getCompatibilities(array $compatibilities, array $incompatibilities): array
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
                    $componentsToAdjacent[$i][$j]--;
                }
            }
        }

        return $componentsToAdjacent;
    }

    private function isDisabled(int $id): bool
    {
        return !empty(session("c$id-disabled-from"));
    }
}
