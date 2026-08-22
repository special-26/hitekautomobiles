<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Advisor
        |--------------------------------------------------------------------------
        */

        $advisor = Role::firstOrCreate([
            'name' => 'Advisor',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Floor Manager
        |--------------------------------------------------------------------------
        */

        $floorManager = Role::firstOrCreate([
            'name' => 'Floor Manager',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Mechanic
        |--------------------------------------------------------------------------
        */

        $mechanic = Role::firstOrCreate([
            'name' => 'Mechanic',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Store Manager
        |--------------------------------------------------------------------------
        */

        $storeManager = Role::firstOrCreate([
            'name' => 'Store Manager',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customer Support
        |--------------------------------------------------------------------------
        */

        $customerSupport = Role::firstOrCreate([
            'name' => 'Customer Support',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        // Super Admin gets everything.
        $superAdmin->syncPermissions(
            Permission::all()
        );

        // Admin
        $admin->syncPermissions([
            'view dashboard',

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            'view vehicles',
            'create vehicles',
            'edit vehicles',
            'delete vehicles',

            'view job cards',
            'create job cards',
            'edit job cards',

            'view bays',
            'manage bays',
            'assign technicians',

            'view service status',
            'update service status',

            'view inventory',
            'manage inventory',

            'view payments',
            'create payments',
            'manage payments',

            'view reports',
            'view daily reports',

            'view bookings',
            'create bookings',
            'edit bookings',
            'cancel bookings',
        ]);

        // Advisor
        $advisor->syncPermissions([
            'view dashboard',

            'view customers',
            'create customers',
            'edit customers',

            'view vehicles',
            'create vehicles',
            'edit vehicles',

            'view job cards',
            'create job cards',
            'edit job cards',

            'view service status',
            'update service status',

            'view bookings',
            'create bookings',
            'edit bookings',

            'view payments',
        ]);

        // Floor Manager
        $floorManager->syncPermissions([
            'view dashboard',

            'view customers',
            'view vehicles',

            'view job cards',
            'edit job cards',

            'view bays',
            'manage bays',
            'assign technicians',

            'view service status',
            'update service status',

            'view reports',
        ]);

        // Mechanic
        $mechanic->syncPermissions([
            'view dashboard',

            'view job cards',

            'view service status',
            'update service status',
        ]);

        // Store Manager
        $storeManager->syncPermissions([
            'view dashboard',

            'view inventory',
            'manage inventory',

            'view job cards',

            'view reports',
        ]);

        // Customer Support
        $customerSupport->syncPermissions([
            'view dashboard',

            'view customers',
            'create customers',
            'edit customers',

            'view vehicles',
            'create vehicles',
            'edit vehicles',

            'view job cards',
            'create job cards',
            'edit job cards',

            'view service status',

            'view bookings',
            'create bookings',
            'edit bookings',

            'view payments',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create / Assign Super Admin User
        |--------------------------------------------------------------------------
        */

        $superAdminUser = User::firstOrCreate(
            [
                'email' => 'admin@hitekautomobiles.com',
            ],
            [
                'name' => 'Hitek Automobiles',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        $superAdminUser->syncRoles([$superAdmin]);
        
    }
}
