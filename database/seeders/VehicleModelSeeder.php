<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'Maruti Suzuki' => [
                ['name' => 'Swift', 'fuel_types' => ['Petrol', 'CNG'], 'image' => 'images/vehicle-models/swift.webp'],
                ['name' => 'Baleno', 'fuel_types' => ['Petrol', 'CNG'], 'image' => 'images/vehicle-models/baleno.webp'],
                ['name' => 'Wagon R', 'fuel_types' => ['Petrol', 'CNG'], 'image' => 'images/vehicle-models/wagon-r.webp'],
                ['name' => 'Brezza', 'fuel_types' => ['Petrol', 'CNG'], 'image' => 'images/vehicle-models/brezza.webp'],
                ['name' => 'Dzire', 'fuel_types' => ['Petrol', 'CNG'], 'image' => 'images/vehicle-models/dzire.webp'],
            ],

            'Hyundai' => [
                ['name' => 'i10', 'fuel_types' => ['Petrol'], 'image' => ''],
                ['name' => 'Grand i10 Nios', 'fuel_types' => ['Petrol', 'CNG'], 'image' => ''],
                ['name' => 'i20', 'fuel_types' => ['Petrol'], 'image' => ''],
                ['name' => 'Venue', 'fuel_types' => ['Petrol', 'Diesel'], 'image' => ''],
                ['name' => 'Creta', 'fuel_types' => ['Petrol', 'Diesel'], 'image' => ''],
            ],

            'Tata Motors' => [
                ['name' => 'Tiago', 'fuel_types' => ['Petrol', 'CNG'], 'image' => ''],
                ['name' => 'Altroz', 'fuel_types' => ['Petrol', 'Diesel', 'CNG'], 'image' => ''],
                ['name' => 'Nexon', 'fuel_types' => ['Petrol', 'Diesel', 'CNG'], 'image' => ''],
                ['name' => 'Punch', 'fuel_types' => ['Petrol', 'CNG'], 'image' => ''],
            ],

            'Mahindra' => [
                ['name' => 'Scorpio', 'fuel_types' => ['Diesel'], 'image' => ''],
                ['name' => 'XUV700', 'fuel_types' => ['Petrol', 'Diesel'], 'image' => ''],
                ['name' => 'Thar', 'fuel_types' => ['Petrol', 'Diesel'], 'image' => ''],
            ],

            'Toyota' => [
                ['name' => 'Innova Crysta', 'fuel_types' => ['Diesel'], 'image' => ''],
                ['name' => 'Fortuner', 'fuel_types' => ['Petrol', 'Diesel'], 'image' => ''],
                ['name' => 'Glanza', 'fuel_types' => ['Petrol'], 'image' => ''],
            ],

            'Honda' => [
                ['name' => 'City', 'fuel_types' => ['Petrol'], 'image' => ''],
                ['name' => 'Amaze', 'fuel_types' => ['Petrol'], 'image' => ''],
            ],
        ];

        foreach ($models as $brandName => $brandModels) {
            $brand = VehicleBrand::where('name', $brandName)->first();

            if (!$brand) {
                $this->command?->warn(
                    "Brand not found: {$brandName}"
                );

                continue;
            }

            foreach ($brandModels as $modelData) {
                VehicleModel::updateOrCreate(
                    [
                        'vehicle_brand_id' => $brand->getKey(),
                        'name' => $modelData['name'],
                        'image' => $modelData['image'] ? $modelData['image'] : null,
                    ],
                    [
                        'slug' => Str::slug(
                            $brandName . '-' . $modelData['name']
                        ),
                        'fuel_types' => $modelData['fuel_types'],
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command?->info('Vehicle models seeded successfully.');
    }
}
