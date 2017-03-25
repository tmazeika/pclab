<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class GraphicsComponent extends Model
{
    use ComponentChild, Validatable, VideoOutputer;

    protected $fillable = [
        'id',
        'component_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'supports_sli',
        'size_x',
    ];

    private $createRules = [
        'id'                  => 'nullable|integer|unique:graphics_components|min:0',
        'component_id'        => 'required|exists:components,id',
        'has_displayport_out' => 'required|boolean',
        'has_dvi_out'         => 'required|boolean',
        'has_hdmi_out'        => 'required|boolean',
        'has_vga_out'         => 'required|boolean',
        'supports_sli'        => 'required|boolean',
        'size_x'              => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                  => 'nullable|integer|unique:graphics_components|min:0',
        'component_id'        => 'nullable|exists:components,id',
        'has_displayport_out' => 'nullable|boolean',
        'has_dvi_out'         => 'nullable|boolean',
        'has_hdmi_out'        => 'nullable|boolean',
        'has_vga_out'         => 'nullable|boolean',
        'supports_sli'        => 'nullable|boolean',
        'size_x'              => 'nullable|integer|min:0',
    ];
}
