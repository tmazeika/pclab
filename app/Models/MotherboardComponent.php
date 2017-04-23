<?php

namespace PCForge\Models;

use PCForge\Presenters\MotherboardComponentPresenter;

class MotherboardComponent extends ComponentChild
{
    protected $fillable = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
        'form_factor_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'pcie3_slots',
        'supports_sli',
        'dimm_gen',
        'dimm_pins',
        'dimm_slots',
        'dimm_max_capacity',
        'atx12v_pins',
        'socket_id',
        'sata_slots',
    ];

    protected $presenter = MotherboardComponentPresenter::class;

    public function form_factor()
    {
        return $this->belongsTo(FormFactor::class);
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}
