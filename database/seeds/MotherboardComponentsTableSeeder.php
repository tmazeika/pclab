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
                'size_y'              => 328,
                'atx12v_pins'         => 8,
                'socket_id'           => 1,
                'sata_slots'          => 5,
            ],
        ]);
    }
}