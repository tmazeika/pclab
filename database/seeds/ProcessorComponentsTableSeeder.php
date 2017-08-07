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
                'cores'            => 4,
                'has_apu'          => true,
                'has_stock_cooler' => false,
                'speed'            => 4200,
                'socket_id'        => 3,
            ],
            [
                'cores'            => 4,
                'has_apu'          => true,
                'has_stock_cooler' => true,
                'speed'            => 3200,
                'socket_id'        => 3,
            ],
            [
                'cores'            => 2,
                'has_apu'          => true,
                'has_stock_cooler' => true,
                'speed'            => 3700,
                'socket_id'        => 3,
            ],
            [
                'cores'            => 8,
                'has_apu'          => true,
                'has_stock_cooler' => false,
                'speed'            => 3600,
                'socket_id'        => 15,
            ],
        ]);
    }
}
