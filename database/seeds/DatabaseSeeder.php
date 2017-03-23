<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FormFactorsTableSeeder::class);
        $this->call(SocketsTableSeeder::class);
        $this->call(StorageSizesTableSeeder::class);
        $this->call(ComponentsTableSeeder::class);
        $this->call(ChassisComponentsTableSeeder::class);
        $this->call(CoolingComponentsTableSeeder::class);
        $this->call(GraphicsComponentsTableSeeder::class);
        $this->call(MemoryComponentsTableSeeder::class);
        $this->call(MotherboardComponentsTableSeeder::class);
        $this->call(PowerComponentsTableSeeder::class);
        $this->call(ProcessorComponentsTableSeeder::class);
        $this->call(StorageComponentsTableSeeder::class);
        $this->call(StorageSizesTableSeeder::class);
        $this->call(ChassisComponentsFormFactorsTableSeeder::class);
        $this->call(ChassisComponentsRadiatorsTableSeeder::class);
        $this->call(CoolingComponentsSocketsTableSeeder::class);
    }
}
