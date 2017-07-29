<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GraphicsComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('graphics_components')->insert([
            [
                'has_displayport_out' => true,
                'has_dvi_out'         => true,
                'has_hdmi_out'        => true,
                'has_vga_out'         => false,
                'supports_sli'        => true,
                'length'              => 280,
            ],
        ]);
    }
}
