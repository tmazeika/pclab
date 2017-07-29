<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sockets')->insert([
            ['name' => 'LGA 775'],
            ['name' => 'LGA 1150'],
            ['name' => 'LGA 1151'],
            ['name' => 'LGA 1155'],
            ['name' => 'LGA 1156'],
            ['name' => 'LGA 1366'],
            ['name' => 'LGA 2011'],
            ['name' => 'FM1'],
            ['name' => 'FM2'],
            ['name' => 'FM2+'],
            ['name' => 'AM2'],
            ['name' => 'AM2+'],
            ['name' => 'AM3'],
            ['name' => 'AM3+'],
            ['name' => 'AM4'],
        ]);
    }
}
