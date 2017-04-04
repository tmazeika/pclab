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
            ['name' => 'chassis'],
            ['name' => 'cooling'],
            ['name' => 'graphics'],
            ['name' => 'memory'],
            ['name' => 'motherboard'],
            ['name' => 'power'],
            ['name' => 'processor'],
            ['name' => 'storage'],
        ]);
    }
}
