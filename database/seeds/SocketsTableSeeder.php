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
            ['name' => 'lga775'],
            ['name' => 'lga1150'],
            ['name' => 'lga1151'],
            ['name' => 'lga1155'],
            ['name' => 'lga1156'],
            ['name' => 'lga1366'],
            ['name' => 'lga2011'],
            ['name' => 'fm1'],
            ['name' => 'fm2'],
            ['name' => 'fm2+'],
            ['name' => 'am2'],
            ['name' => 'am2+'],
            ['name' => 'am3'],
            ['name' => 'am3+'],
            ['name' => 'am4'],
        ]);
    }
}
