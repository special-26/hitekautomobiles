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

        $autoPartsStoreManager = Role::firstOrCreate([
            'name' => 'Auto Parts Store Manager',
            'guard_name' => 'web',
        ]);

        $generalStoreManager = Role::firstOrCreate([
            'name' => 'General Store Manager',
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
        | Mechanic Coordinator
        |--------------------------------------------------------------------------
        */
        $mechanicCoordinator = Role::firstOrCreate([
            'name' => 'Mechanic Coordinator',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */
        $customer = Role::firstOrCreate([
            'name' => 'Customer',
            'guard_name' => 'web',
        ]);

        /*
|--------------------------------------------------------------------------
| Assign Permissions
|--------------------------------------------------------------------------
*/

        // Super Admin gets everything.
        $superAdmin->syncPermissions([
            'owner.dashboard.view',
            'owner.statistics.view',
            'owner.reports.view',
            'owner.activity.view',
            'owner.admins.manage',
        ]);

        // Admin
        $admin->syncPermissions([
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            'roles.view',

            'bays.view',
            'bays.create',
            'bays.update',
            'bays.status.update',
        ]);

        // Advisor
        $advisor->syncPermissions([]);

        // Floor Manager
        $floorManager->syncPermissions([]);

        // Mechanic
        $mechanic->syncPermissions([]);

        // AutoPart Store Manager
        $autoPartsStoreManager->syncPermissions([

            // Auto Parts
            'parts.view',
            'parts.manage',
            'parts.receive',
            'parts.issue',
            'parts.return',
            'parts.adjust',
            'parts.suppliers.manage',
        ]);
        // General Store Manager
        $generalStoreManager->syncPermissions([

            // General Inventory
            'inventory.view',
            'inventory.manage',
            'inventory.receive',
            'inventory.issue',
            'inventory.return',
            'inventory.adjust',
        ]);

        // Customer Support
        $customerSupport->syncPermissions([]);

        $mechanicCoordinator->syncPermissions([]);

        $customer->syncPermissions([
            'customers.view',
            'customers.update',
            'vehicles.view',
            'vehicles.create',
            'vehicles.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create / Assign Super Admin User
        |--------------------------------------------------------------------------
        */

        $superAdminUser = User::firstOrCreate(
            [
                'email' => 'superadmin@hitekautomobiles.com',
            ],
            [
                'name' => 'Hitek Automobiles',
                'password' => 'password',
                'is_active' => true,
            ]
        );
        $AdminUser = User::firstOrCreate(
            [
                'email' => 'admin@hitekautomobiles.com',
            ],
            [
                'name' => 'Hitek Admin',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        $superAdminUser->syncRoles([$superAdmin]);
        $AdminUser->syncRoles([$admin]);
    }
}
