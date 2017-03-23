<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoolingComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cooling_components')->insert([
            [
                'component_id' => 3,
                'is_air'       => true,
                'fan_xy'       => 120,
                'fan_z'        => 159,
                'radiator_x'   => 0,
                'radiator_z'   => 0,
                'max_memory_z' => 37,
            ],
        ]);
    }
}
