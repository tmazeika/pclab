<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChassisComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chassis_components')->insert([
            [
                'component_id'                => 2,
                'max_fan_width'               => 194,
                'max_graphics_length_blocked' => 300,
                'max_graphics_length_full'    => 420,
                'audio_headers'               => 1,
                'fan_headers'                 => 3,
                'max_eatx_length'             => 264,
                'usb2_headers'                => 0,
                'usb3_headers'                => 1,
                'uses_sata_power'             => true,
                '2p5_bays'                    => 2,
                '3p5_bays'                    => 0,
                'adaptable_bays'              => 5,
            ],
            [
                'component_id'                => 13,
                'max_fan_width'               => 180,
                'max_graphics_length_blocked' => 310,
                'max_graphics_length_full'    => 440,
                'audio_headers'               => 1,
                'fan_headers'                 => 2,
                'max_eatx_length'             => 0,
                'usb2_headers'                => 1,
                'usb3_headers'                => 1,
                'uses_sata_power'             => false,
                '2p5_bays'                    => 2,
                '3p5_bays'                    => 0,
                'adaptable_bays'              => 8,
            ],
        ]);
    }
}
