<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Builder;
use PCForge\Presenters\MotherboardComponentPresenter;

/**
 * @property int id
 * @property int audio_headers
 * @property int fan_headers
 * @property int usb2_headers
 * @property int usb3_headers
 * @property int form_factor_id
 * @property bool has_displayport_out
 * @property bool has_dvi_out
 * @property bool has_hdmi_out
 * @property bool has_vga_out
 * @property int pcie3_slots
 * @property bool supports_sli
 * @property int dimm_gen
 * @property int dimm_pins
 * @property int dimm_slots
 * @property int dimm_max_capacity
 * @property int atx12v_pins
 * @property int socket_id
 * @property int sata_slots
 *
 * @property FormFactor form_factor
 * @property Socket socket
 */
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
        return $this->belongsTo(FormFactor::class, 'id');
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }

    public function scopeWithAll(Builder $query): void
    {
        parent::scopeWithAll($query);

        $query->with('form_factor', 'socket');
    }
}
