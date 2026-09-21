<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\PartCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssignPartCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryMappings = [
            'engine' => 'Engine Parts',
            'engine parts' => 'Engine Parts',

            'brake' => 'Braking System',
            'brakes' => 'Braking System',
            'braking' => 'Braking System',
            'braking system' => 'Braking System',

            'suspension' => 'Suspension',
            'suspension & steering' => 'Suspension',

            'steering' => 'Steering',

            'electrical' => 'Electrical',
            'battery' => 'Electrical',

            'lighting' => 'Lighting',
            'lights' => 'Lighting',

            'body' => 'Body Parts',
            'body parts' => 'Body Parts',
            'body & exterior' => 'Body Parts',

            'exterior' => 'Exterior Accessories',
            'exterior accessories' => 'Exterior Accessories',

            'interior' => 'Interior Parts',
            'interior parts' => 'Interior Parts',

            'ac' => 'AC & Cooling',
            'cooling' => 'AC & Cooling',
            'ac & cooling' => 'AC & Cooling',
            'ac & hvac' => 'AC & Cooling',
            'cooling system' => 'AC & Cooling',

            'filter' => 'Filters',
            'filters' => 'Filters',

            'clutch' => 'Clutch & Transmission',
            'transmission' => 'Clutch & Transmission',
            'clutch & transmission' => 'Clutch & Transmission',

            'tyre' => 'Tyres & Wheels',
            'tyres' => 'Tyres & Wheels',
            'wheel' => 'Tyres & Wheels',
            'tyres & wheels' => 'Tyres & Wheels',

            'oil' => 'Lubricants & Fluids',
            'engine oil' => 'Lubricants & Fluids',
            'lubricants' => 'Lubricants & Fluids',
            'fluids' => 'Lubricants & Fluids',
            'fluids & lubricants' => 'Lubricants & Fluids',

            'consumables & workshop' => 'General Accessories',

            'service kits' => 'General Accessories',

        ];

        $parts = Part::query()
            ->whereNull('part_category_id')
            ->get();

        $assigned = 0;
        $unmatched = 0;

        foreach ($parts as $part) {
            $existingCategory = Str::lower(
                trim((string) $part->category)
            );

            if ($existingCategory === '') {
                $unmatched++;

                $this->command?->warn(
                    "No category found for part: {$part->name}"
                );

                continue;
            }

            $categoryName = $categoryMappings[$existingCategory]
                ?? null;

            if (!$categoryName) {
                $unmatched++;

                $this->command?->warn(
                    "Unmatched category '{$part->category}' for part: {$part->name}"
                );

                continue;
            }

            $category = PartCategory::where(
                'slug',
                Str::slug($categoryName)
            )->first();

            if (!$category) {
                $this->command?->error(
                    "Category does not exist: {$categoryName}"
                );

                continue;
            }

            $part->update([
                'part_category_id' => $category->id,
            ]);

            $assigned++;
        }

        $this->command?->info(
            "Parts assigned: {$assigned}"
        );

        $this->command?->warn(
            "Parts requiring manual mapping: {$unmatched}"
        );
    }
}
