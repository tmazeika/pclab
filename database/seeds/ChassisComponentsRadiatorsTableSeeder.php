<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChassisComponentsRadiatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chassis_components_radiators')->insert([
            [
                'chassis_component_id' => 1,
                'is_max_absolute'      => true,
                'max_size_x'           => 120,
                'fan_size_xz'          => 120,
            ],
            [
                'chassis_component_id' => 1,
                'is_max_absolute'      => false,
                'max_size_x'           => 360,
                'fan_size_xz'          => 120,
            ],
            [
                'chassis_component_id' => 1,
                'is_max_absolute'      => false,
                'max_size_x'           => 280,
                'fan_size_xz'          => 140,
            ],
        ]);
    }
}
