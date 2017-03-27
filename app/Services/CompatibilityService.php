<?php

namespace PCForge\Services;

use PCForge\ChassisComponent;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\CoolingComponent;
use PCForge\GraphicsComponent;
use PCForge\MotherboardComponent;

class CompatibilityService implements CompatibilityServiceContract
{
    public function isAllowedToSelect(int $componentId): bool
    {
        // TODO: check if disabled
        return !session("$componentId.selected");
    }

    public function select(int $componentId, string $componentType): array
    {
        $modelName = 'PCForge\\' . ucfirst($componentType) . 'Component';
        $component = $modelName::where('component_id', $componentId)->firstOrFail();

        return $this->$componentType($component);
    }

    public function deselect(int $componentId, string $componentType): array
    {
        return $this->select($componentId, $componentType);
    }

    private function chassis(ChassisComponent $chassis)
    {
        // cooling
        $badCooling = CoolingComponent::where('height', '>', $chassis->max_fan_height)
            ->pluck('component_id')
            ->all();

        // graphics
        // TODO: allow full length when appropriate
        $badGraphics = GraphicsComponent::where('length', '>', $chassis->max_graphics_length_blocked)
            ->pluck('component_id')
            ->all();

        // motherboard
        $badMotherboard = MotherboardComponent::whereNotIn('form_factor_id', $chassis->form_factors->pluck('id')->all())
            ->pluck('component_id')
            ->all();

        return array_merge($badCooling, $badGraphics, $badMotherboard);
    }
}
