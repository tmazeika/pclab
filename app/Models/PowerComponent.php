<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class PowerComponent extends Model implements CompatibilityNode
{
    use ExtendedModel, ComponentChild, Validatable;

    const WATTS_INC = 50;

    private const CREATE_RULES = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'required|exists:components,id|unique:power_components',
        'atx12v_pins'  => 'required|integer|min:0',
        'sata_powers'  => 'required|integer|min:0',
        'is_modular'   => 'required|boolean',
        'watts_out'    => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'nullable|exists:components,id|unique:power_components',
        'atx12v_pins'  => 'nullable|integer|min:0',
        'sata_powers'  => 'nullable|integer|min:0',
        'is_modular'   => 'nullable|boolean',
        'watts_out'    => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'atx12v_pins',
        'sata_powers',
        'is_modular',
        'watts_out',
    ];

    public function getStaticallyCompatibleComponents(): array
    {
        return [$this->id];
    }

    public function getStaticallyIncompatibleComponents(): array
    {
        // power
        $components[] = PowerComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getDynamicallyCompatibleComponents(array $selected): array
    {
        // TODO: check atx12v_pins + sata_powers

        return PowerComponent
            ::where('watts_out', '>=', $this->getTotalWattsUsage($selected))
            ->pluck('component_id')
            ->all();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): array
    {
        // TODO: check atx12v_pins + sata_powers

        return PowerComponent
            ::where('watts_out', '<', $this->getTotalWattsUsage($selected))
            ->pluck('component_id')
            ->all();
    }

    private function getTotalWattsUsage(array $selected): int
    {
        $totalWattsUsage = 100;
        $selectedComponents = Component
            ::whereIn('id', array_keys($selected))
            ->pluck('watts_usage', 'id');

        foreach ($selectedComponents as $id => $wattsUsage) {
            $count = $selected[$id];
            $totalWattsUsage += $wattsUsage * $count;
        }

        // ceil total watts usage to next increment of 50
        return ceil((float)$totalWattsUsage / self::WATTS_INC) * self::WATTS_INC;
    }
}
