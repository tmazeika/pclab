<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoolingComponentsSocketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cooling_components_sockets')->insert([
            [
                'cooling_component_id' => 1,
                'socket_id'            => 1,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 2,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 3,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 4,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 5,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 6,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 7,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 8,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 9,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 10,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 11,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 12,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 13,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 14,
            ],
            [
                'cooling_component_id' => 1,
                'socket_id'            => 15,
            ],
        ]);
    }
}
