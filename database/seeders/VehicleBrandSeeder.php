<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Maruti Suzuki',
                'logo' => 'images/vehicle-brands/maruti-suzuki.webp',
                'is_active' => true,
            ],
            [
                'name' => 'Hyundai',
                'logo' => 'images/vehicle-brands/hyundai.webp',
                'is_active' => true,
            ],
            [
                'name' => 'Tata Motors',
                'logo' => 'images/vehicle-brands/tata.webp',
                'is_active' => true,
            ],
            [
                'name' => 'Mahindra',
                'logo' => 'images/vehicle-brands/mahindra.webp',
                'is_active' => true,
            ],
            [
                'name' => 'Toyota',
                'logo' => 'images/vehicle-brands/toyota.webp',
                'is_active' => true,
            ],
            [
                'name' => 'Honda',
                'logo' => 'images/vehicle-brands/honda.webp',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            VehicleBrand::updateOrCreate(
                [
                    'name' => $brand['name'],
                ],
                [
                    'slug' => Str::slug($brand['name']),
                    'logo' => $brand['logo'],
                    'is_active' => $brand['is_active'],
                ]
            );
        }

        $this->command?->info('Vehicle brands seeded successfully.');
    }
}
