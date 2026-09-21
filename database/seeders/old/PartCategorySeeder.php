<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Engine Parts',
            'Braking System',
            'Suspension',
            'Steering',
            'Electrical',
            'Lighting',
            'Body Parts',
            'Exterior Accessories',
            'Interior Parts',
            'AC & Cooling',
            'Filters',
            'Clutch & Transmission',
            'Tyres & Wheels',
            'Lubricants & Fluids',
            'General Accessories',
        ];

        foreach ($categories as $categoryName) {
            PartCategory::updateOrCreate(
                [
                    'slug' => Str::slug($categoryName),
                ],
                [
                    'name' => $categoryName,
                    'is_active' => true,
                ]
            );
        }

        $this->command?->info('Part categories seeded successfully.');
    }
}
