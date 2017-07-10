<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\PowerComponentCompatibilityProvider;
use PCForge\Presenters\PowerComponentPresenter;

/**
 * @property int id
 * @property int atx12v_pins
 * @property int sata_powers
 * @property int is_modular
 * @property int watts_out
 */
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
