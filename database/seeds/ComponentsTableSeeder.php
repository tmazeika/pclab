<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('components')->insert([
            [
                'asin'        => 'B01MXSI216',
                'name'        => 'Intel Core i7-7700K',
                'watts_usage' => 91,
                'weight'      => 85,
            ],
            [
                'asin'        => 'B01F0KWL6A',
                'name'        => 'Phanteks Enthoo Evolv: Tempered Glass Edition',
                'watts_usage' => 0,
                'weight'      => 10200,
            ],
            [
                'asin'        => 'B005O65JXI',
                'name'        => 'Cooler Master Hyper 212 EVO',
                'watts_usage' => 3,
                'weight'      => 569,
            ],
            [
                'asin'        => 'B01GXOWUDQ',
                'name'        => 'MSI GeForce GTX 1080 ARMOR',
                'watts_usage' => 180,
                'weight'      => 907,
            ],
            [
                'asin'        => 'B01EIDY1EK',
                'name'        => 'Crucial Ballistix Sport LT',
                'watts_usage' => 10,
                'weight'      => 145,
            ],
            [
                'asin'        => 'B012NH05UW',
                'name'        => 'ASUS Z170-A',
                'watts_usage' => 0,
                'weight'      => 998,
            ],
            [
                'asin'        => 'B00OBRE5UE',
                'name'        => 'Samsung 850 EVO',
                'watts_usage' => 2,
                'weight'      => 54,
            ],
            [
                'asin'        => 'B00M2UINC8',
                'name'        => 'Corsair HX750i',
                'watts_usage' => 0,
                'weight'      => 3227,
            ],
            [
                'asin'        => 'B010T6CWI2',
                'name'        => 'Intel Core i5-6500',
                'watts_usage' => 35,
                'weight'      => 295,
            ],
            [
                'asin'        => 'B015VPX2EO',
                'name'        => 'Intel Core i3-6100',
                'watts_usage' => 51,
                'weight'      => 272,
            ],
            [
                'asin'        => 'B06W9JXK4G',
                'name'        => 'AMD Ryzen 7 1800X',
                'watts_usage' => 95,
                'weight'      => 119,
            ],
            [
                'asin'        => 'B009O7YUF6',
                'name'        => 'AMD FX-8350',
                'watts_usage' => 125,
                'weight'      => 200,
            ],
            [
                'asin'        => 'B00Q2Z11QE',
                'name'        => 'Fractal Design Define R5 Blackout Edition',
                'watts_usage' => 0,
                'weight'      => 10700,
            ],
        ]);
    }
}
