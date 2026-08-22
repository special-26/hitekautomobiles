<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // Dashboard
            'view dashboard',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            // Vehicles
            'view vehicles',
            'create vehicles',
            'edit vehicles',
            'delete vehicles',

            // Job Cards
            'view job cards',
            'create job cards',
            'edit job cards',
            'delete job cards',

            // Workshop / Bays
            'view bays',
            'manage bays',
            'assign technicians',

            // Service Status
            'view service status',
            'update service status',

            // Inventory
            'view inventory',
            'manage inventory',

            // Payments
            'view payments',
            'create payments',
            'manage payments',

            // Reports
            'view reports',
            'view daily reports',

            // Bookings
            'view bookings',
            'create bookings',
            'edit bookings',
            'cancel bookings',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
