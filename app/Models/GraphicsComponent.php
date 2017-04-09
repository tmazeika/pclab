<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class GraphicsComponent extends Model implements CompatibilityNode
{
    use ExtendedModel, ComponentChild, Validatable, VideoOutputer;

    private const CREATE_RULES = [
        'id'                  => 'nullable|integer|unique:graphics_components|min:0',
        'component_id'        => 'required|exists:components,id|unique:graphics_components',
        'has_displayport_out' => 'required|boolean',
        'has_dvi_out'         => 'required|boolean',
        'has_hdmi_out'        => 'required|boolean',
        'has_vga_out'         => 'required|boolean',
        'supports_sli'        => 'required|boolean',
        'length'              => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'                  => 'nullable|integer|unique:graphics_components|min:0',
        'component_id'        => 'nullable|exists:components,id|unique:graphics_components',
        'has_displayport_out' => 'nullable|boolean',
        'has_dvi_out'         => 'nullable|boolean',
        'has_hdmi_out'        => 'nullable|boolean',
        'has_vga_out'         => 'nullable|boolean',
        'supports_sli'        => 'nullable|boolean',
        'length'              => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'supports_sli',
        'length',
    ];

    public function getAllDirectlyCompatibleComponents(): array
    {
        return [$this->id];
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        // graphics
        $components[] = GraphicsComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDynamicallyCompatibleComponents(array $selectedComponentIds): array
    {
        return [];
    }

    public function getAllDynamicallyIncompatibleComponents(array $selectedComponentIds): array
    {
        return [];
    }
}
