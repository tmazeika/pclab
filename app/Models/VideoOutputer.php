<?php

namespace PCForge\Models;

trait VideoOutputer
{
    public function outputsString()
    {
        $outputs = [];

        if ($this->has_displayport_out) {
            array_push($outputs, 'DisplayPort');
        }
        if ($this->has_dvi_out) {
            array_push($outputs, 'DVI');
        }
        if ($this->has_hdmi_out) {
            array_push($outputs, 'HDMI');
        }
        if ($this->has_vga_out) {
            array_push($outputs, 'VGA');
        }

        return implode(' / ', $outputs);
    }
}
