<?php

namespace PCForge\Models;

use PCForge\Presenters\PowerComponentPresenter;

class PowerComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'atx12v_pins',
        'sata_powers',
        'is_modular',
        'watts_out',
    ];

    protected $presenter = PowerComponentPresenter::class;
}
