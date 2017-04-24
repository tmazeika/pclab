<?php

namespace PCForge\Compatibility\Services;

use Illuminate\Support\Collection;
use PCForge\AdjacencyMatrix;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    public function getIncompatibilities(array $selection): Collection
    {
        if (empty($selection)) {
            return collect();
        }

        $idToKey = function (int $id) {
            return $id - 1;
        };

        $keyToId = function (int $id) {
            return $id + 1;
        };

        $components = Component::all();

        foreach ($components as $component) {
            /** @var ComponentChild $child */
            $child = $component->child;

            $provider = $child->compatibilityProvider();
            $key = $component->id - 1;

            $incompatible[$key] = $provider->getStaticallyIncompatible($child)
                ->union($provider->getDynamicallyIncompatible($child, $selection))
                ->map($idToKey)
                ->when(!$component->is_available, function () {
                    return collect();
                })
                ->toArray();

            $compatible[$key] = $provider->getStaticallyCompatible($child)
                ->union($provider->getDynamicallyCompatible($child, $selection))
                ->map($idToKey)
                ->diff($incompatible[$key])
                ->push($key)
                ->when(!$component->is_available, function () {
                    return collect();
                })
                ->toArray();
        }

        // build adjacency matrices
        $incompatibleAdjacencyMatrix = new AdjacencyMatrix($incompatible ?? []);
        $compatibleAdjacencyMatrix = new AdjacencyMatrix($compatible ?? []);

        $compatible = $components
            ->pluck('id')
            ->map($idToKey)
            ->mapWithKeys(function (int $node) use ($incompatibleAdjacencyMatrix, $compatibleAdjacencyMatrix, $keyToId) {
                $compatAm = clone $compatibleAdjacencyMatrix;

                for ($j = 0; $j < $compatAm->getCount(); $j++) {
                    if ($incompatibleAdjacencyMatrix->hasEdge($node, $j)) {
                        $compatAm->removeNode($j);
                    }
                }

                return [$keyToId($node) => collect($compatAm->getReachable($node))->map($keyToId)];
            });

        return $components->whereIn('id', $components
            ->pluck('id')
            ->diff(collect($selection)
                ->map(function (int $id) use ($compatible) {
                    return $compatible->get($id);
                })
                ->filter(function (Collection $adjacent) {
                    return $adjacent->isNotEmpty();
                })
                ->reduce(function ($carry, Collection $adjacent) {
                    return $carry ? $carry->intersect($adjacent) : $adjacent;
                }))
        );
    }
}
