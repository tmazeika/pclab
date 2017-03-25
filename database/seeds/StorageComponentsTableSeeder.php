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
                'component_id'     => 7,
                'capacity'         => 500,
                'is_ssd'           => true,
                'storage_width_id' => 1,
            ],
        ]);
    }
}
