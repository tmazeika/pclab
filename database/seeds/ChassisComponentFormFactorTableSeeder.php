<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChassisComponentFormFactorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chassis_component_form_factor')->insert([
            [
                'chassis_component_id' => 1,
                'form_factor_id'       => 1,
            ],
            [
                'chassis_component_id' => 1,
                'form_factor_id'       => 2,
            ],
            [
                'chassis_component_id' => 1,
                'form_factor_id'       => 3,
            ],
            [
                'chassis_component_id' => 1,
                'form_factor_id'       => 4,
            ],
            [
                'chassis_component_id' => 2,
                'form_factor_id'       => 1,
            ],
            [
                'chassis_component_id' => 2,
                'form_factor_id'       => 3,
            ],
            [
                'chassis_component_id' => 2,
                'form_factor_id'       => 4,
            ],
        ]);
    }
}
