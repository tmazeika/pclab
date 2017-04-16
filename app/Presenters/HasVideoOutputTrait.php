<?php

namespace PCForge\Presenters;

trait HasVideoOutputTrait
{
    public function buildVideoOutputStr(): string
    {
        $outputs = [];

        if ($this->entity->has_displayport_out) {
            $outputs[] = 'DisplayPort';
        }

        if ($this->entity->has_dvi_out) {
            $outputs[] = 'DVI';
        }

        if ($this->entity->has_hdmi_out) {
            $outputs[] = 'HDMI';
        }

        if ($this->entity->has_vga_out) {
            $outputs[] = 'VGA';
        }

        return implode(' / ', $outputs);
    }
}
