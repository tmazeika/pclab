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
                'name'                => 'chassis',
                'is_allowed_multiple' => false,
                'is_always_required'  => true,
            ],
            [
                'name'                => 'processor',
                'is_allowed_multiple' => false,
                'is_always_required'  => true,
            ],
            [
                'name'                => 'graphics',
                'is_allowed_multiple' => true,
                'is_always_required'  => false,
            ],
            [
                'name'                => 'memory',
                'is_allowed_multiple' => true,
                'is_always_required'  => true,
            ],
            [
                'name'                => 'motherboard',
                'is_allowed_multiple' => false,
                'is_always_required'  => true,
            ],
            [
                'name'                => 'cooling',
                'is_allowed_multiple' => false,
                'is_always_required'  => false,
            ],
            [
                'name'                => 'storage',
                'is_allowed_multiple' => true,
                'is_always_required'  => true,
            ],
            [
                'name'                => 'power',
                'is_allowed_multiple' => false,
                'is_always_required'  => true,
            ],
        ]);
    }
}
