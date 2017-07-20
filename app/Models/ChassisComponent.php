<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;
use PCForge\Presenters\ChassisComponentPresenter;

/**
 * @property int id
 * @property int max_cooling_fan_height
 * @property int max_graphics_length_blocked
 * @property int max_graphics_length_full
 * @property int audio_headers
 * @property int fan_headers
 * @property int usb2_headers
 * @property int usb3_headers
 * @property bool uses_sata_power
 * @property int 2p5_bays
 * @property int 3p5_bays
 * @property int adaptable_bays
 * @property int cage_2p5_bays
 * @property int cage_3p5_bays
 * @property int cage_adaptable_bays
 *
 * @property Collection form_factors
 * @property Collection radiators
 */
class ChassisComponent extends ComponentChild
{
    protected $fillable = [
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
        'cage_2p5_bays',
        'cage_3p5_bays',
        'cage_adaptable_bays',
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
