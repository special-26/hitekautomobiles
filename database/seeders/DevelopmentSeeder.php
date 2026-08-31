<?php

namespace Database\Seeders;

use App\Models\Bay;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Test Customer User
        |--------------------------------------------------------------------------
        */

        $user = User::firstOrCreate(
            [
                'email' => 'testcustomer@example.com',
            ],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Test Customer
        |--------------------------------------------------------------------------
        */

        $customer = Customer::firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'customer_code' => 'CUS-000001',
                'name' => 'Test Customer',
                'phone' => '9876543210',
                'email' => 'testcustomer@example.com',
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Test Vehicle
        |--------------------------------------------------------------------------
        */

        $vehicle = Vehicle::firstOrCreate(
            [
                'registration_number' => 'CH01AB1234',
            ],
            [
                'customer_id' => $customer->id,
                'make' => 'Maruti Suzuki',
                'model' => 'Baleno',
                'variant' => 'Alpha',
                'fuel_type' => 'Petrol',
                'manufacturing_year' => 2023,
                'color' => 'White',
                'current_odometer' => 25000,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Test Employee
        |--------------------------------------------------------------------------
        */

        $employeeUser = User::firstOrCreate(
            [
                'email' => 'advisor@example.com',
            ],
            [
                'name' => 'Test Advisor',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $employee = Employee::firstOrCreate(
            [
                'user_id' => $employeeUser->id,
            ],
            [
                'employee_code' => 'EMP-000001',
                'phone' => '9876543211',
                'designation' => 'Service Advisor',
                'status' => 'active',
            ]
        );

        $department = Department::firstOrCreate(
            [
                'name' => 'General Service',
            ],
            [
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Test Bay
        |--------------------------------------------------------------------------
        */

        $bay = Bay::firstOrCreate(
            [
                'code' => 'BAY-01',
            ],
            [
                'name' => 'Bay 01',
                'department_id' => $department->id,
                'type' => 'General',
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Test Job Card
        |--------------------------------------------------------------------------
        */

        // JobCard::firstOrCreate(
        //     [
        //         'job_card_number' => 'JC-000001',
        //     ],
        //     [
        //         'customer_id' => $customer->id,
        //         'vehicle_id' => $vehicle->id,
        //         'advisor_id' => $employee->id,
        //         'bay_id' => $bay->id,
        //         'complaint' => 'Engine making unusual noise.',
        //         'work_description' => 'Inspect engine and diagnose the issue.',
        //         'estimated_cost' => 2500,
        //         'status' => 'open',
        //         'priority' => 'normal',
        //     ]
        // );


    }
}
