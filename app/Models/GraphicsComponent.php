<?php

namespace PCForge\Models;

use PCForge\Presenters\GraphicsComponentPresenter;

class GraphicsComponent extends ComponentChild
{
    protected $fillable = [
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'supports_sli',
        'length',
    ];

    protected $presenter = GraphicsComponentPresenter::class;
}
