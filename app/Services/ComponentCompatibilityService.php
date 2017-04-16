<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\AdjacencyMatrix;
use PCForge\Compatibility\CompatibilityProvider;
use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;

class ComponentCompatibilityService implements ComponentCompatibilityServiceContract
{
    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    /** @var array $compatibilityProviders */
    private $compatibilityProviders;

    /**
     * ComponentCompatibilityService constructor.
     *
     * @param ComponentSelectionServiceContract $componentSelectionService
     * @param CompatibilityProvider[] $compatibilityProviders
     */
    public function __construct(ComponentSelectionServiceContract $componentSelectionService, array $compatibilityProviders)
    {
        $this->componentSelectionService = $componentSelectionService;
        $this->compatibilityProviders = $this->buildCompatibilityProvidersDictionary($compatibilityProviders);
    }

    public function computeIncompatibilities(): Collection
    {
        $selected = $this->componentSelectionService->allSelected(['id']);

        if ($selected->count() > 0) {
            $components = Component::select('id')->get();
            $computedCompatibilities = $this->computeCompatibilities();

            return $components
                ->pluck('id')
                ->diff($selected
                    ->pluck('id')
                    ->map(function (int $id) use ($computedCompatibilities) {
                        return $computedCompatibilities->get($id);
                    })
                    ->filter(function (Collection $adjacent) {
                        return $adjacent->isNotEmpty();
                    })
                    ->reduce(function ($carry, Collection $adjacent) {
                        return $carry ? $carry->intersect($adjacent) : $adjacent;
                    })
                )
                ->map(function (int $id) use ($components) {
                    return $components->where('id', $id);
                });
        }

        return collect();
    }

    /**
     * @param CompatibilityProvider[] $compatibilityProviders
     *
     * @return array
     */
    private function buildCompatibilityProvidersDictionary(array $compatibilityProviders): array
    {
        foreach ($compatibilityProviders as $compatibilityProvider) {
            $dict[$compatibilityProvider->getComponentType()] = $compatibilityProvider;
        }

        return $dict ?? [];
    }

    private function computeCompatibilities(): Collection
    {
        /** @var Collection $components */
        $components = Component::select('id', 'component_type_id', 'is_available')->get();

        /** @var Component $component */
        foreach ($components as $component) {
            $key = $component->id - 1;
            $child = $component->child();

            /** @var CompatibilityProvider $compatibilityProvider */
            $compatibilityProvider = $this->compatibilityProviders[$component->type->name];

            $incompatibilities[$key] = $compatibilityProvider->getStaticallyIncompatible($child)
                ->union($compatibilityProvider->getDynamicallyIncompatible($child))
                ->when(!$component->is_available, function () {
                    return collect();
                })
                ->map(function (int $id) {
                    return $id - 1;
                })
                ->toArray();

            $compatibilities[$key] = $compatibilityProvider->getStaticallyCompatible($child)
                ->union($compatibilityProvider->getDynamicallyCompatible($child))
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

        return $components
            ->map(function (Component $component) {
                return $component->id - 1;
            })
            ->mapWithKeys(function (int $node) use ($compatibilitiesAdjacencyMatrix, $incompatibilitiesAdjacencyMatrix) {
                $compatAM = clone $compatibilitiesAdjacencyMatrix;

                for ($j = 0; $j < $compatAM->getCount(); $j++) {
                    if ($incompatibilitiesAdjacencyMatrix->hasEdge($node, $j)) {
                        $compatAM->removeNode($j);
                    }
                }

                return [$node + 1 => collect($compatAM->getReachable($node))->map(function (int $node) {
                    return $node + 1;
                })];
            });
    }
}
