<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoryComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memory_components')->insert([
            [
                'count'         => 2,
                'height'        => 12,
                'capacity_each' => 8,
                'ddr_gen'       => 4,
                'pins'          => 288,
            ],
            [
                'count'         => 2,
                'height'        => 10,
                'capacity_each' => 8,
                'ddr_gen'       => 4,
                'pins'          => 288,
            ],
        ]);
    }
}
