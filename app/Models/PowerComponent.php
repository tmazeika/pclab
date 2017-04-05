<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class PowerComponent extends Model implements CompatibilityNode
{
    use ComponentChild, Validatable;

    const WATTS_INC = 50;

    protected $fillable = [
        'id',
        'component_id',
        'atx12v_pins',
        'sata_powers',
        'is_modular',
        'watts_out',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'required|exists:components,id|unique:power_components',
        'atx12v_pins'  => 'required|integer|min:0',
        'sata_powers'  => 'required|integer|min:0',
        'is_modular'   => 'required|boolean',
        'watts_out'    => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'nullable|exists:components,id|unique:power_components',
        'atx12v_pins'  => 'nullable|integer|min:0',
        'sata_powers'  => 'nullable|integer|min:0',
        'is_modular'   => 'nullable|boolean',
        'watts_out'    => 'nullable|integer|min:0',
    ];

    public function getAllDirectlyCompatibleComponents(): array
    {
        return [$this->id];
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        // power
        $components[] = PowerComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDynamicallyCompatibleComponents(array $selectedComponentIds): array
    {
        // TODO: check atx12v_pins + sata_powers

        $totalWattsUsage = 100;
        $selectedComponents = Component::whereIn('id', array_keys($selectedComponentIds))->pluck('id', 'watts_usage');

        foreach ($selectedComponents as $componentId => $wattsUsage) {
            $count = $selectedComponentIds[$componentId];
            $totalWattsUsage += $wattsUsage * $count;
        }

        // ceil total watts usage to next increment of 50
        $totalWattsUsage = ceil((float) $totalWattsUsage / self::WATTS_INC) * self::WATTS_INC;

        return PowerComponent
            ::where('watts_out', '>=', $totalWattsUsage)
            ->pluck('component_id')
            ->all();
    }

    public function getAllDynamicallyIncompatibleComponents(array $selectedComponentIds): array
    {
        return [];
    }
}
