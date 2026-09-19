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

            // Service Task Catalog
            'service-tasks.view',
            'service-tasks.create',
            'service-tasks.update',
            'service-tasks.status.update',

            // Service Task Suggested Parts
            'service-task-parts.view',
            'service-task-parts.create',
            'service-task-parts.remove',

        ]);

        // Advisor
        $advisor->syncPermissions([
            'dashboard.view',

            // Customers
            'customers.view',
            'customers.create',
            'customers.update',

            // Vehicles
            'vehicles.view',
            'vehicles.create',
            'vehicles.update',

            // Employees - View only if required for display
            'employees.view',

            // Departments
            'departments.view',

            // Bays - View only
            'bays.view',

            // Job Cards
            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            'job-card-parts.view',

            // Job Card Tasks
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',

            // Billing
            'job-cards.estimate.create',
            'job-cards.estimate.update',
            'job-cards.final-bill.create',
            'job-cards.final-bill.update',
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

            // Job Card Parts
            'job-card-parts.view',
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

            // Employees
            'employees.view',

            // Departments
            'departments.view',

            // Customers - View only
            'customers.view',

            // Vehicles - View only
            'vehicles.view',

            // Job Cards
            'job-cards.view',
            'job-cards.update',

            // Job Card Tasks
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            // Mechanic and Bay Assignment
            'job-cards-tasks.assign-mechanic',
            'job-cards-tasks.assign-bay',

            // Bays
            'bays.view',
            'bays.update',

            // Parts - Catalog View Only
            'parts.view',

            // Job Card Parts
            'job-card-parts.view',
            'job-card-parts.request',
            'job-card-parts.create',
            'job-card-parts.update',
            'job-card-parts.remove',
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
