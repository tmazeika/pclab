<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('component_types')->insert([
            [
                'name'                        => 'chassis',
                'allows_multiple'             => false,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'cooling',
                'allows_multiple'             => false,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'graphics',
                'allows_multiple'             => true,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'memory',
                'allows_multiple'             => true,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'motherboard',
                'allows_multiple'             => false,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'power',
                'allows_multiple'             => false,
                'has_dynamic_compatibilities' => true,
            ],
            [
                'name'                        => 'processor',
                'allows_multiple'             => false,
                'has_dynamic_compatibilities' => false,
            ],
            [
                'name'                        => 'storage',
                'allows_multiple'             => true,
                'has_dynamic_compatibilities' => true,
            ],
        ]);
    }
}
