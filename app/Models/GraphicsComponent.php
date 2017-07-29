<?php

namespace PCForge\Models;

use PCForge\Presenters\GraphicsComponentPresenter;

/**
 * @property int id
 * @property bool has_displayport_out
 * @property bool has_dvi_out
 * @property bool has_hdmi_out
 * @property bool has_vga_out
 * @property bool supports_sli
 * @property int length
 */
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
