<?php

namespace PCForge\Models;

trait VideoOutputer
{
    public function outputsString()
    {
        $outputs = [];

        if ($this->has_displayport_out) {
            $outputs[] = 'DisplayPort';
        }

        if ($this->has_dvi_out) {
            $outputs[] = 'DVI';
        }

        if ($this->has_hdmi_out) {
            $outputs[] = 'HDMI';
        }

        if ($this->has_vga_out) {
            $outputs[] = 'VGA';
        }

        return implode(' / ', $outputs);
    }
}
