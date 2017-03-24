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
                'component_id'  => 5,
                'count'         => 2,
                'size_z'        => 12,
                'capacity_each' => 8,
                'ddr_gen'       => 4,
                'pins'          => 288,
            ],
        ]);
    }
}