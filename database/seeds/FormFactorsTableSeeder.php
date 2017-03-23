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
            ['name' => 'atx'],
            ['name' => 'eatx'],
            ['name' => 'microatx'],
            ['name' => 'miniitx'],
        ]);
    }
}
