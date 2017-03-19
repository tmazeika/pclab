<?php

use Illuminate\Database\Seeder;

class MiscComponentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('misc_component_types')->insert([
            ['name' => 'cablemods'],
        ]);
    }
}
