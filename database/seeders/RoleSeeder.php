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
            Permission::query()
                ->where('guard_name', 'web')
                ->pluck('name')
                ->all()
        ]);

        // Admin
        $admin->syncPermissions([
            // Dashboard
            'dashboard.view',

            // Employees
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            // Department
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.status.update',

            // Roles
            'roles.view',
            'roles.create',
            'roles.update',

            // Bays
            'bays.view',
            'bays.create',
            'bays.update',
            'bays.status.update',

            // Customers
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.status.update',

            // Vehicles
            'vehicles.view',
            'vehicles.create',
            'vehicles.update',
            'vehicles.status.update',

            // Job Cards
            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            // Parts
            'parts.view',
            'parts.create',
            'parts.update',
            'parts.status.update',

            // Job Card Task Permissions
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',
        ]);

        // Advisor
        $advisor->syncPermissions([
            'dashboard.view',

            'customers.view',
            'customers.create',
            'customers.update',

            // Employees
            'employees.view',

            'departments.view',

            'vehicles.view',
            'vehicles.create',
            'vehicles.update',

            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            // Parts
            'parts.view',
            'parts.create',
            'parts.update',
            'parts.status.update',

            // Job Card Task Permissions
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            'bays.view',
        ]);

        // Floor Manager
        $floorManager->syncPermissions([
            'dashboard.view',

            'employees.view',

            'customers.view',
            'vehicles.view',

            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            'bays.view',
            'bays.update',

            'parts.view',
            'inventory.view',
        ]);

        // Mechanic
        $mechanic->syncPermissions([
            'dashboard.view',

            'job-cards.view',
            'job-cards-tasks.view',

            'bays.view',
            'parts.view',
        ]);

        // AutoPart Store Manager
        $autoPartsStoreManager->syncPermissions([
            'dashboard.view',

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
            'dashboard.view',

            // General Inventory
            'inventory.view',
            'inventory.manage',
            'inventory.receive',
            'inventory.issue',
            'inventory.return',
            'inventory.adjust',
        ]);

        // Customer Support
        $customerSupport->syncPermissions([
            'dashboard.view',

            'customers.view',
            'customers.create',
            'customers.update',

            'vehicles.view',
            'vehicles.create',
            'vehicles.update',

            'job-cards.view',
        ]);

        $mechanicCoordinator->syncPermissions([
            'dashboard.view',

            'employees.view',

            'departments.view',

            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            // Job Card Task Permissions
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            'bays.view',
            'bays.update',

            // Employees
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            'parts.view',
        ]);

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
