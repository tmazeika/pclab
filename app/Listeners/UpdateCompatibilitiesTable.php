<?php

namespace PCForge\Listeners;

use Illuminate\Support\Facades\DB;
use PCForge\Events\NewComponentAdded;
use PCForge\Models\Compatibility;
use PCForge\Models\CompatibilityNode;
use PCForge\Models\Component;

class UpdateCompatibilitiesTable
{
    private $components = [];

    /**
     * Handle the event.
     *
     * @param NewComponentAdded $event
     */
    public function handle(NewComponentAdded $event): void
    {
        Component::orderBy('id')->get()->each(function ($component, $key) {
            $componentModel = 'PCForge\Models\\' . ucfirst($component->type->name) . 'Component';
            $this->addComponent($key, $componentModel::where('component_id', $component->id)->first());
        });

        $this->updateCompatibilitiesTable();
    }

    public function addComponent(int $key, CompatibilityNode $compatibilityNode): void
    {
        // compatible components, relatedIndex = 0
        $this->components[$key][] = $this->zeroIndexArray($compatibilityNode->getAllDirectlyCompatibleComponents());

        // incompatible components, relatedIndex = 1
        $this->components[$key][] = $this->zeroIndexArray($compatibilityNode->getAllDirectlyIncompatibleComponents());
    }

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
        DB::table((new Compatibility)->getTable())->truncate();

        $compatibilityAdjacencyMatrix = $this->buildAdjacencyMatrix($this->components, 0);
        $incompatibilityAdjacencyMatrix = $this->buildAdjacencyMatrix($this->components, 1);
        $n = count($compatibilityAdjacencyMatrix);

        // step 1
        for ($i = 0; $i < $n; $i++) {
            // get copies of the adjacency matrices
            $compatAM = $compatibilityAdjacencyMatrix;
            $incompatAM = $incompatibilityAdjacencyMatrix;

            // step 2
            for ($j = 0; $j < $n; $j++) {
                // if this row has an edge with this column...
                if ($incompatAM[$i][$j] === 1) {
                    // zero the row and column in the compatibility matrix corresponding to this row in the
                    // incompatibility matrix
                    for ($k = 0; $k < $n; $k++) {
                        $compatAM[$j][$k] = $compatAM[$k][$j] = 0;
                    }
                }
            }

            // step 3 and insert into DB
            foreach ($this->getReachableNodes($compatAM, $i) as $compatComponent) {
                Compatibility::create([
                    'component_1_id' => $i + 1,
                    'component_2_id' => $compatComponent + 1,
                ]);
            }
        }
    }

    private function buildAdjacencyMatrix(array $components, int $relatedIndex): array
    {
        $n = count($components);
        $matrix = [];

        for ($i = 0; $i < $n; $i++) {
            $relatedIds = $components[$i][$relatedIndex];

            for ($j = 0; $j < $n; $j++) {
                $matrix[$i][$j] = in_array($j, $relatedIds, true) ? 1 : 0;
            }
        }

        return $matrix;
    }

    private function getReachableNodes(array $matrix, int $fromCol): array
    {
        $n = count($matrix);
        $reachableNodes = [];
        $stack = [$fromCol];

        while (!empty($stack)) {
            $i = array_pop($stack);

            // check that this column hasn't already been reached
            if (!in_array($i, $reachableNodes, true)) {
                for ($j = 0; $j < $n; $j++) {
                    // if this row has an edge with this column...
                    if ($matrix[$i][$j] === 1) {
                        // check that this column hasn't already been added once
                        if (!in_array($i, $reachableNodes, true)) {
                            $reachableNodes[] = $i;
                        }

                        $stack[] = $j;
                    }
                }
            }
        }

        return $reachableNodes;
    }

    private function stringifyMatrix(array $matrix): string
    {
        $n = count($matrix);
        $str = '   ';

        for ($i = 0; $i < $n; $i++) {
            $str .= $i + 1 . ' ';
        }

        $str .= PHP_EOL;

        for ($j = 0; $j < $n; $j++) {
            $str .= $j + 1 . ' ';

            if ($j < 9) {
                $str .= ' ';
            }

            for ($i = 0; $i < $n; $i++) {
                $str .= $matrix[$i][$j] . ' ';

                if ($i > 8) {
                    $str .= ' ';
                }
            }

            $str .= PHP_EOL;
        }

        return $str;
    }
}
