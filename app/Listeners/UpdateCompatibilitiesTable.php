<?php

namespace PCForge\Listeners;

use Illuminate\Support\Facades\DB;
use PCForge\AdjacencyMatrix;
use PCForge\Events\ComponentModified;
use PCForge\Models\Compatibility;
use PCForge\Models\CompatibilityNode;
use PCForge\Models\Component;

class UpdateCompatibilitiesTable
{
    /** @var array $compatibleNodesToAdjacent */
    private $compatibleNodesToAdjacent = [];

    /** @var array $incompatibleNodesToAdjacent */
    private $incompatibleNodesToAdjacent = [];

    /**
     * Handle the event.
     *
     * @param ComponentModified $event
     */
    public function handle(ComponentModified $event): void
    {
        Component::orderBy('id')->get()->each(function(Component $component, int $key) {
            $this->addComponent($key, $component->castToActualComponent());
        });

        $this->updateCompatibilitiesTable();
    }

    public function addComponent(int $key, CompatibilityNode $compatibilityNode): void
    {
        // compatible components
        $this->compatibleNodesToAdjacent[$key] =
            $this->zeroIndexArray($compatibilityNode->getAllDirectlyCompatibleComponents());

        // incompatible components
        $this->incompatibleNodesToAdjacent[$key] =
            $this->zeroIndexArray($compatibilityNode->getAllDirectlyIncompatibleComponents());
    }

    /**
     * Converts a one-based array to a zero-based array.
     *
     * @param array $arr a one-based array
     *
     * @return array
     */
    private function zeroIndexArray(array $arr): array
    {
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i]--;
        }

        return $arr;
    }

    /**
     * Procedure:
     * 1. Pick a component
     * 2. In the compatibility matrix, zero the rows and columns that have an edge in the picked component's
     *    incompatibility matrix column
     * 3. Mark all reachable components from the picked component's compatibility matrix column as 'compatible'
     */
    public function updateCompatibilitiesTable(): void
    {
        // create compatibility table from scratch
        DB::table((new Compatibility)->getTable())->truncate();

        $compatibilityAdjacencyMatrix = new AdjacencyMatrix($this->compatibleNodesToAdjacent);
        $incompatibilityAdjacencyMatrix = new AdjacencyMatrix($this->incompatibleNodesToAdjacent);

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
                Compatibility::create([
                    'component_1_id' => $node + 1,
                    'component_2_id' => $compatNode + 1,
                ]);
            }
        }
    }
}
