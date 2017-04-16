<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class GraphicsComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'supports_sli',
        'length',
    ];

    protected $presenter = 'PCForge\Presenters\GraphicsComponentPresenter';

    public function getStaticallyCompatibleComponents(): Collection
    {
        return collect([$this->id]);
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        // graphics
        return GraphicsComponent::where('id', '!=', $this->id)->pluck('component_id')->flatten();
    }

    public function getDynamicallyCompatibleComponents(array $selected): Collection
    {
        // motherboard
        $count = $selected[$this->id] ?? 0;

        return MotherboardComponent
            ::whereIn('component_id', array_keys($selected))
            ->where('pcie3_slots', '>=', $count)
            ->pluck('component_id')
            ->flatten();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): Collection
    {
        // motherboard
        $count = $selected[$this->id] ?? 0;

        return MotherboardComponent
            ::whereIn('component_id', array_keys($selected))
            ->where('pcie3_slots', '<', $count)
            ->pluck('component_id')
            ->flatten();
    }
}
