<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\PowerComponentCompatibilityProvider;
use PCForge\Presenters\PowerComponentPresenter;

class PowerComponent extends ComponentChild
{
    protected $fillable = [
        'atx12v_pins',
        'sata_powers',
        'is_modular',
        'watts_out',
    ];

    protected $presenter = PowerComponentPresenter::class;

    protected $compatibilityProvider = PowerComponentCompatibilityProvider::class;
}
