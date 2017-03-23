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
                'max_fan_z'                   => 194,
                'max_graphics_size_x_blocked' => 300,
                'max_graphics_size_x_full'    => 420,
                'audio_headers'               => 1,
                'fan_headers'                 => 3,
                'max_eatx_y'                  => 264,
                'usb2_headers'                => 0,
                'usb3_headers'                => 1,
                'uses_sata_power'             => true,
                '2p5_bays'                    => 3,
                '3p5_bays'                    => 8,
            ],
        ]);
    }
}
