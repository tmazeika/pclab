<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessorComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processor_components')->insert([
            [
                'component_id'     => 1,
                'cores'            => 4,
                'has_apu'          => true,
                'has_stock_cooler' => false,
                'speed'            => 4200,
                'socket_id'        => 3,
            ],
            [
                'component_id'     => 9,
                'cores'            => 4,
                'has_apu'          => true,
                'has_stock_cooler' => true,
                'speed'            => 3200,
                'socket_id'        => 3,
            ],
            [
                'component_id'     => 10,
                'cores'            => 2,
                'has_apu'          => true,
                'has_stock_cooler' => true,
                'speed'            => 3700,
                'socket_id'        => 3,
            ],
            [
                'component_id'     => 11,
                'cores'            => 8,
                'has_apu'          => true,
                'has_stock_cooler' => false,
                'speed'            => 3600,
                'socket_id'        => 15,
            ],
            [
                'component_id'     => 12,
                'cores'            => 8,
                'has_apu'          => false,
                'has_stock_cooler' => true,
                'speed'            => 4000,
                'socket_id'        => 14,
            ],
        ]);
    }
}
