<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = [
            'Maruti Suzuki',
            'Hyundai',
            'Honda',
            'Tata',
            'Mahindra',
            'Toyota',
            'Kia',
            'Volkswagen',
        ];

        $models = [
            'Swift',
            'Baleno',
            'Creta',
            'City',
            'Nexon',
            'XUV700',
            'Fortuner',
            'Seltos',
            'Virtus',
        ];

        $cities = [
            'Chandigarh',
            'Mohali',
            'Panchkula',
            'Zirakpur',
            'Kharar',
        ];

        for ($i = 1; $i <= 100; $i++) {

            $customer = Customer::create([
                'customer_code' => 'DUMMY-' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'public_token' => (string) Str::uuid(),

                'name' => fake()->name(),

                'phone' => '9' . fake()->unique()->numerify('#########'),

                'email' => fake()->unique()->safeEmail(),

                'address' => fake()->streetAddress(),

                'city' => fake()->randomElement($cities),

                'state' => 'Punjab',

                'pincode' => fake()->numerify('1600##'),

                'is_active' => true,
            ]);

            /*
             * Give some customers multiple vehicles
             */
            $vehicleCount = fake()->numberBetween(1, 3);

            for ($vehicleIndex = 1; $vehicleIndex <= $vehicleCount; $vehicleIndex++) {

                $lastService = fake()->dateTimeBetween('-12 months', '-1 month');

                /*
                 * Different scenarios so CRM filters can be tested.
                 */
                $scenario = fake()->randomElement([
                    'service_upcoming',
                    'service_due',
                    'service_overdue',
                    'normal',
                ]);

                $nextService = match ($scenario) {

                    'service_upcoming' =>
                    now()->addDays(fake()->numberBetween(1, 7)),

                    'service_due' =>
                    today(),

                    'service_overdue' =>
                    now()->subDays(fake()->numberBetween(1, 120)),

                    default =>
                    now()->addDays(fake()->numberBetween(15, 180)),
                };


                /*
                 * Insurance scenarios
                 */
                $insuranceScenario = fake()->randomElement([
                    '7_days',
                    '30_days',
                    'expired',
                    'normal',
                ]);

                $insuranceExpiry = match ($insuranceScenario) {

                    '7_days' =>
                    now()->addDays(fake()->numberBetween(1, 7)),

                    '30_days' =>
                    now()->addDays(fake()->numberBetween(8, 30)),

                    'expired' =>
                    now()->subDays(fake()->numberBetween(1, 180)),

                    default =>
                    now()->addDays(fake()->numberBetween(31, 365)),
                };


                Vehicle::create([
                    'customer_id' => $customer->id,

                    'registration_number' =>
                    'PB' .
                        fake()->numberBetween(1, 99) .
                        fake()->randomLetter() .
                        fake()->randomLetter() .
                        fake()->unique()->numberBetween(1000, 9999),

                    'make' => fake()->randomElement($makes),

                    'model' => fake()->randomElement($models),

                    'variant' => fake()->randomElement([
                        'LXI',
                        'VXI',
                        'ZXI',
                        'Sport',
                        'Premium',
                    ]),

                    'fuel_type' => fake()->randomElement([
                        'Petrol',
                        'Diesel',
                        'CNG',
                    ]),

                    'manufacturing_year' =>
                    fake()->numberBetween(2015, 2026),

                    'color' => fake()->randomElement([
                        'White',
                        'Black',
                        'Silver',
                        'Grey',
                        'Red',
                        'Blue',
                    ]),

                    'current_odometer' =>
                    fake()->numberBetween(5000, 150000),

                    'last_service_at' => $lastService,

                    'next_service_at' => $nextService,

                    'insurance_expiry_at' => $insuranceExpiry,

                    'is_active' => true,
                ]);
            }
        }
    }
}
