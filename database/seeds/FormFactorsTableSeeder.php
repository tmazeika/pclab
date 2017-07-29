<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormFactorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_factors')->insert([
            ['name' => 'ATX'],
            ['name' => 'E-ATX'],
            ['name' => 'Micro-ATX'],
            ['name' => 'Mini-ITX'],
        ]);
    }
}
