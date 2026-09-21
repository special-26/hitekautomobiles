<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            VehicleBrandSeeder::class,
            VehicleModelSeeder::class,
            PartCategorySeeder::class,
            PartSeeder::class,
            ModelPartSeeder::class,
        ]);
    }
}
