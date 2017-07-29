<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PowerComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('power_components')->insert([
            [
                'atx12v_pins' => 16,
                'sata_powers' => 12,
                'is_modular'  => true,
                'watts_out'   => 750,
                'length'      => 180,
            ],
        ]);
    }
}
