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
        // chassis
        return ChassisComponent
            ::pluck('component_id')
            ->all();
    }

    public function getStaticallyIncompatibleComponents(): array
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('atx12v_pins', '>', $this->atx12v_pins)
            ->pluck('component_id')
            ->all();

        // power
        $components[] = PowerComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getDynamicallyCompatibleComponents(array $selected): array
    {
        return [];
    }

    public function getDynamicallyIncompatibleComponents(array $selected): array
    {
        // power
        $systemWattsUsage = $this->getSystemWattsUsage($selected);

        if ($this->watts_out < $systemWattsUsage) {
            $components[] = Component
                ::where('watts_usage', '>', 0)
                ->pluck('id')
                ->all();

            $components[] = [$this->component_id];
        } else {
            $components[] = Component
                ::where('watts_usage', '>', $this->watts_out - $systemWattsUsage)
                ->pluck('id')
                ->all();
        }

        // storage
        $storageCount = StorageComponent
            ::whereIn('component_id', array_keys($selected))
            ->count();

        if ($storageCount === $this->sata_powers) {
            $components[] = StorageComponent
                ::whereNotIn('component_id', array_keys($selected))
                ->pluck('component_id')
                ->all();
        } else if ($storageCount > $this->sata_powers) {
            $components[] = [$this->component_id];
        }

        return !empty($components) ? array_merge(...$components) : [];
    }

    private function getSystemWattsUsage(array $selected): int
    {
        $totalWattsUsage = 150;
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
