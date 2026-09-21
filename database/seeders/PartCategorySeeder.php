<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Engine Parts',
                'image' => 'images/part-categories/engine-parts.webp',
            ],
            [
                'name' => 'Brake System',
                'image' => 'images/part-categories/brake-system.webp',
            ],
            [
                'name' => 'Suspension',
                'image' => 'images/part-categories/suspension.webp',
            ],
            [
                'name' => 'Clutch & Transmission',
                'image' => 'images/part-categories/clutch-transmission.webp',
            ],
            [
                'name' => 'Electrical Parts',
                'image' => 'images/part-categories/electrical-parts.webp',
            ],
            [
                'name' => 'Filters',
                'image' => 'images/part-categories/filters.webp',
            ],
            [
                'name' => 'AC & Cooling',
                'image' => 'images/part-categories/ac-cooling.webp',
            ],
            [
                'name' => 'Body Parts',
                'image' => 'images/part-categories/body-parts.webp',
            ],
            [
                'name' => 'Lighting',
                'image' => 'images/part-categories/lighting.webp',
            ],
            [
                'name' => 'Steering',
                'image' => 'images/part-categories/steering.webp',
            ],
            [
                'name' => 'Wheels & Tyres',
                'image' => 'images/part-categories/wheels-tyres.webp',
            ],
            [
                'name' => 'Fluids & Lubricants',
                'image' => 'images/part-categories/fluids-lubricants.webp',
            ],
        ];


        foreach ($categories as $category) {
            PartCategory::updateOrCreate(
                [
                    'name' => $category['name'],
                ],
                [
                    'slug' => Str::slug($category['name']),
                    'image' => $category['image'],
                    'is_active' => true,
                ]
            );
        }

        $this->command?->info(
            'Part categories seeded successfully.'
        );
    }
}
