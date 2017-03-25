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
                'component_id'      => 3,
                'is_air'            => true,
                'fan_width'         => 120,
                'radiator_length'   => 0,
                'max_memory_height' => 37,
            ],
        ]);
    }
}
