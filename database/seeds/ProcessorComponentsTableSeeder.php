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
                'component_id' => 1,
                'cores'        => 4,
                'has_apu'      => true,
                'speed'        => 4200,
                'socket_id'    => 3,
            ],
        ]);
    }
}
