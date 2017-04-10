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
            ],
            [
                'name'                        => 'cooling',
                'allows_multiple'             => false,
            ],
            [
                'name'                        => 'graphics',
                'allows_multiple'             => true,
            ],
            [
                'name'                        => 'memory',
                'allows_multiple'             => true,
            ],
            [
                'name'                        => 'motherboard',
                'allows_multiple'             => false,
            ],
            [
                'name'                        => 'power',
                'allows_multiple'             => false,
            ],
            [
                'name'                        => 'processor',
                'allows_multiple'             => false,
            ],
            [
                'name'                        => 'storage',
                'allows_multiple'             => true,
            ],
        ]);
    }
}
