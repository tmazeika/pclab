<?php

namespace PCForge\Listeners;

use PCForge\AdjacencyMatrix;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\Compatibility;
use PCForge\Models\CompatibilityNode;
use PCForge\Models\Component;

class UpdateCompatibilitiesTable
{
    /** @var CompatibilityServiceContract $compatibilityService */
    private $compatibilityService;

    /** @var array $compatibleComponentsToAdjacent */
    private $compatibleComponentsToAdjacent = [];

    /** @var array $incompatibleComponentsToAdjacent */
    private $incompatibleComponentsToAdjacent = [];

    public function __construct(CompatibilityServiceContract $compatibilityService)
    {
        $this->compatibilityService = $compatibilityService;
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        Component::each(function (Component $component) {
            // TODO: check availability
            $this->addComponent($component->id - 1, $component->toCompatibilityNode());
        });

        $this->updateCompatibilitiesTable();
    }

    public function addComponent(int $key, CompatibilityNode $compatibilityNode): void
    {
        // compatible components
        $this->compatibleComponentsToAdjacent[$key] = $compatibilityNode->getAllDirectlyCompatibleComponents();

        // incompatible components
        $this->incompatibleComponentsToAdjacent[$key] = $compatibilityNode->getAllDirectlyIncompatibleComponents();
    }

    private function updateCompatibilitiesTable(): void
    {
        // create compatibility table from scratch
        Compatibility::truncate();

        $compatibilities = $this->compatibilityService->getAllCompatibilities(
            $this->compatibleComponentsToAdjacent, $this->incompatibleComponentsToAdjacent
        );

        foreach ($compatibilities as $component1 => $adjacent) {
            foreach ($adjacent as $component2) {
                Compatibility::create([
                    'component_1_id' => $component1 + 1,
                    'component_2_id' => $component2 + 1,
                ]);
            }
        }
    }
}
