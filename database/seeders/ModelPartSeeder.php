<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelPartSeeder extends Seeder
{
    public function run(): void
    {
        $modelParts = [

            // Maruti Suzuki
            'Maruti Suzuki' => [
                'Swift',
                'Baleno',
                'Wagon R',
                'Brezza',
                'Dzire',
            ],

            // Hyundai
            'Hyundai' => [
                'i10',
                'Grand i10 Nios',
                'i20',
                'Venue',
                'Creta',
            ],

            // Tata Motors
            'Tata Motors' => [
                'Tiago',
                'Altroz',
                'Nexon',
                'Punch',
            ],

            // Mahindra
            'Mahindra' => [
                'Scorpio',
                'XUV700',
                'Thar',
            ],

            // Toyota
            'Toyota' => [
                'Innova Crysta',
                'Fortuner',
                'Glanza',
            ],

            // Honda
            'Honda' => [
                'City',
                'Amaze',
            ],
        ];

        $partNumbers = [
            'ENG-OIL-5W30',
            'OIL-FILTER-001',
            'AIR-FILTER-001',
            'BRK-PAD-FRONT',
            'CABIN-FILTER-001',
            'SPARK-PLUG-001',
            'WIPER-BLADE-001',
        ];

        foreach ($modelParts as $brandName => $models) {

            foreach ($models as $modelName) {

                $vehicleModel = VehicleModel::where('name', $modelName)
                    ->whereHas('brand', function ($query) use ($brandName) {
                        $query->where('name', $brandName);
                    })
                    ->first();

                if (! $vehicleModel) {
                    $this->command->warn(
                        "Vehicle model not found: {$brandName} - {$modelName}"
                    );

                    continue;
                }

                $parts = Part::whereIn('part_number', $partNumbers)->get();

                if ($parts->isEmpty()) {
                    $this->command->warn(
                        "No parts found for model: {$brandName} - {$modelName}"
                    );

                    continue;
                }

                $vehicleModel->parts()->syncWithoutDetaching(
                    $parts->pluck('id')->toArray()
                );

                $this->command->info(
                    "Parts assigned to: {$brandName} - {$modelName}"
                );
            }
        }

        $this->command->info('Model-part relationships seeded successfully.');
    }
}
