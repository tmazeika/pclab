<?php

namespace PCForge\Services;

use Illuminate\Support\Facades\DB;
use PCForge\ChassisComponent;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\CoolingComponent;
use PCForge\CoolingComponentSocket;
use PCForge\GraphicsComponent;
use PCForge\MotherboardComponent;
use PCForge\ProcessorComponent;
use PCForge\Socket;

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
        // chassis
        $badChassis = ChassisComponent::where('id', '!=', $chassis->id)->pluck('component_id')->all();

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

        return array_merge($badChassis, $badCooling, $badGraphics, $badMotherboard);
    }

    private function processor(ProcessorComponent $processor)
    {
        $socketId = $processor->socket->id;

        // cooling
        $coolingComponentsTable = (new CoolingComponent)->getTable();
        $coolingComponentSocketTable = (new CoolingComponentSocket)->getTable();
        $badCooling = CoolingComponent::whereNotExists(function($query) use ($socketId, $coolingComponentsTable, $coolingComponentSocketTable) {
            $query->select(DB::raw(1))
                ->from($coolingComponentSocketTable)
                ->whereRaw("$coolingComponentSocketTable.cooling_component_id = $coolingComponentsTable.id")
                ->whereRaw("$coolingComponentSocketTable.socket_id = $socketId");
        })->pluck('component_id')->all();

        // TODO: memory

        // TODO: motherboard

        // processor
        $badProcessors = ProcessorComponent::where('id', '!=', $processor->id)->pluck('component_id')->all();

        return array_merge($badCooling, $badProcessors);
    }
}
