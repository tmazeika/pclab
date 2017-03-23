<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('storage_sizes')->insert([
            ['name' => '2p5'],
            ['name' => '3p5'],
        ]);
    }
}
