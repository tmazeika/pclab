<?php

namespace PCForge\Services;

use PCForge\AdjacencyMatrix;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\Compatibility;
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

        $components = Component::where('is_available', true);

        // first pass: (in)directly incompatible components
        $staticallyIncompatible = $components
            ->whereNotIn('id', Compatibility
                ::where('component_1_id', $id)
                ->pluck('component_2_id'))
            ->get();

        // second pass: dynamically incompatible components
        // TODO

        return $staticallyIncompatible
            ->pluck('id')
            ->filter(function (int $incompatId) use ($id, $count) {
                $disabledFrom = session("c$incompatId-disabled-from", []);
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

    public function getAllCompatibilities(array $compatibleComponentsToAdjacent, array $incompatibleComponentsToAdjacent): array
    {
        $arr = [];

        $compatibilityAdjacencyMatrix = new AdjacencyMatrix(
            $this->zeroBaseAdjacentIds($compatibleComponentsToAdjacent)
        );

        $incompatibilityAdjacencyMatrix = new AdjacencyMatrix(
            $this->zeroBaseAdjacentIds($incompatibleComponentsToAdjacent)
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
