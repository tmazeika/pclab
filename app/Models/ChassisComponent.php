<?php

namespace PCForge\Models;

use PCForge\Presenters\ChassisComponentPresenter;

class ChassisComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'max_cooling_fan_height',
        'max_graphics_length_blocked',
        'max_graphics_length_full',
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
        'uses_sata_power',
        '2p5_bays',
        '3p5_bays',
        'adaptable_bays',
    ];

    protected $presenter = ChassisComponentPresenter::class;

    public function form_factors()
    {
        return $this->belongsToMany(FormFactor::class);
    }

    public function radiators()
    {
        return $this->belongsToMany(ChassisComponentsRadiator::class);
    }
}
