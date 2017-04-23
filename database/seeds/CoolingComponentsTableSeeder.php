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
                'is_air'            => true,
                'fan_width'         => 120,
                'height'            => 159,
                'max_memory_height' => 37,
                'radiator_length'   => 0,
            ],
        ]);
    }
}
