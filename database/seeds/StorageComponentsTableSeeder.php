<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('storage_components')->insert([
            [
                'capacity' => 1000,
                'is_ssd'   => true,
                'width'    => '2p5',
            ],
        ]);
    }
}
