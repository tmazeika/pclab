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
                'max_fan_width'        => 120,
                'max_length'           => 360,
            ],
            [
                'chassis_component_id' => 1,
                'max_fan_width'        => 140,
                'max_length'           => 280,
            ],
            [
                'chassis_component_id' => 2,
                'max_fan_width'        => 0,
                'max_length'           => 420,
            ],
        ]);
    }
}
