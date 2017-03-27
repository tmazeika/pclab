<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotherboardComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motherboard_components')->insert([
            [
                'component_id'        => 6,
                'audio_headers'       => 1,
                'fan_headers'         => 4,
                'usb2_headers'        => 2,
                'usb3_headers'        => 2,
                'form_factor_id'      => 1,
                'has_displayport_out' => true,
                'has_dvi_out'         => true,
                'has_hdmi_out'        => true,
                'has_vga_out'         => true,
                'pcie3_slots'         => 3,
                'supports_sli'        => true,
                'dimm_gen'            => 4,
                'dimm_pins'           => 288,
                'dimm_slots'          => 4,
                'dimm_max_capacity'   => 64,
                'length'              => 328,
                'atx12v_pins'         => 8,
                'socket_id'           => 1,
                'sata_slots'          => 5,
            ],
            [
                'component_id'        => 14,
                'audio_headers'       => 1,
                'fan_headers'         => 2,
                'usb2_headers'        => 3,
                'usb3_headers'        => 1,
                'form_factor_id'      => 1,
                'has_displayport_out' => false,
                'has_dvi_out'         => false,
                'has_hdmi_out'        => false,
                'has_vga_out'         => false,
                'pcie3_slots'         => 2,
                'supports_sli'        => false,
                'dimm_gen'            => 3,
                'dimm_pins'           => 240,
                'dimm_slots'          => 4,
                'dimm_max_capacity'   => 32,
                'length'              => 330,
                'atx12v_pins'         => 4,
                'socket_id'           => 14,
                'sata_slots'          => 6,
            ],
            [
                'component_id'        => 15,
                'audio_headers'       => 1,
                'fan_headers'         => 4,
                //'form_factor_id'      => 1,
                'form_factor_id'      => 2,
                'usb2_headers'        => 2,
                'usb3_headers'        => 2,
                'has_displayport_out' => false,
                'has_dvi_out'         => true,
                'has_hdmi_out'        => true,
                'has_vga_out'         => true,
                'pcie3_slots'         => 2,
                'supports_sli'        => false,
                'dimm_gen'            => 4,
                'dimm_pins'           => 288,
                'dimm_slots'          => 4,
                'dimm_max_capacity'   => 64,
                'length'              => 330,
                'atx12v_pins'         => 8,
                'socket_id'           => 15,
                'sata_slots'          => 4,
            ],
        ]);
    }
}
