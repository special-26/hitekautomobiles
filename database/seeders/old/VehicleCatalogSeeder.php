<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = [
            'Maruti Suzuki' => [
                'Alto',
                'Alto K10',
                'S-Presso',
                'Celerio',
                'Wagon R',
                'Swift',
                'Dzire',
                'Baleno',
                'Fronx',
                'Brezza',
                'Ertiga',
                'XL6',
                'Eeco',
                'Ignis',
                'Ciaz',
                'Grand Vitara',
                'Jimny',
                'S-Cross',
            ],

            'Hyundai' => [
                'Santro',
                'Grand i10 Nios',
                'i20',
                'i20 N Line',
                'Aura',
                'Verna',
                'Exter',
                'Venue',
                'Creta',
                'Alcazar',
                'Tucson',
                'Kona Electric',
                'Ioniq 5',
            ],

            'Tata' => [
                'Tiago',
                'Tigor',
                'Altroz',
                'Punch',
                'Nexon',
                'Nexon EV',
                'Harrier',
                'Safari',
                'Curvv',
                'Curvv EV',
                'Tiago EV',
                'Tigor EV',
            ],

            'Mahindra' => [
                'Bolero',
                'Bolero Neo',
                'Scorpio',
                'Scorpio N',
                'Thar',
                'Thar Roxx',
                'XUV300',
                'XUV 3XO',
                'XUV400',
                'XUV500',
                'XUV700',
                'Marazzo',
            ],

            'Toyota' => [
                'Glanza',
                'Urban Cruiser',
                'Urban Cruiser Hyryder',
                'Innova Crysta',
                'Innova Hycross',
                'Fortuner',
                'Rumion',
                'Camry',
                'Vellfire',
                'Hilux',
            ],

            'Honda' => [
                'Amaze',
                'City',
                'City e:HEV',
                'Jazz',
                'WR-V',
                'Elevate',
                'Civic',
                'CR-V',
            ],

            'Kia' => [
                'Sonet',
                'Seltos',
                'Carens',
                'Carnival',
                'EV6',
                'EV9',
            ],

            'Renault' => [
                'Kwid',
                'Triber',
                'Kiger',
                'Duster',
                'Captur',
            ],

            'Nissan' => [
                'Magnite',
                'Kicks',
                'Terrano',
            ],

            'Volkswagen' => [
                'Polo',
                'Vento',
                'Virtus',
                'Taigun',
                'Tiguan',
            ],

            'Skoda' => [
                'Fabia',
                'Rapid',
                'Slavia',
                'Kushaq',
                'Kodiaq',
                'Superb',
                'Octavia',
            ],

            'MG' => [
                'Comet EV',
                'Astor',
                'Hector',
                'Hector Plus',
                'ZS EV',
                'Gloster',
                'Windsor EV',
            ],

            'Ford' => [
                'Figo',
                'Aspire',
                'Freestyle',
                'EcoSport',
                'Endeavour',
                'Ikon',
            ],

            'Jeep' => [
                'Compass',
                'Meridian',
                'Wrangler',
                'Grand Cherokee',
            ],

            'Citroen' => [
                'C3',
                'C3 Aircross',
                'C5 Aircross',
                'Basalt',
                'eC3',
            ],

            'Isuzu' => [
                'D-Max',
                'MU-X',
                'V-Cross',
            ],

            'Fiat' => [
                'Punto',
                'Linea',
                'Avventura',
                'Grande Punto',
            ],
        ];

        foreach ($catalog as $brandName => $models) {
            $brand = VehicleBrand::updateOrCreate(
                [
                    'slug' => Str::slug($brandName),
                ],
                [
                    'name' => $brandName,
                    'image' => 'images/vehicle-brands/' . Str::slug($brandName) . '.webp',
                    'is_active' => true,
                ]
            );

            foreach (array_unique($models) as $modelName) {
                $brand->models()->updateOrCreate(
                    [
                        'slug' => Str::slug($modelName),
                    ],
                    [
                        'name' => $modelName,
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command?->info('Vehicle brands and models seeded successfully.');
    }
}
