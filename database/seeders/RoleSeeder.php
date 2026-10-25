<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $advisor = Role::firstOrCreate([
            'name' => 'Advisor',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Nuxt / Operational Roles
        |--------------------------------------------------------------------------
        |
        | These roles are still used by the Nuxt applications.
        |
        */

        $floorManager = Role::firstOrCreate([
            'name' => 'Floor Manager',
            'guard_name' => 'web',
        ]);

        $mechanic = Role::firstOrCreate([
            'name' => 'Mechanic',
            'guard_name' => 'web',
        ]);

        $autoPartsStoreManager = Role::firstOrCreate([
            'name' => 'Auto Parts Store Manager',
            'guard_name' => 'web',
        ]);

        $generalStoreManager = Role::firstOrCreate([
            'name' => 'General Store Manager',
            'guard_name' => 'web',
        ]);

        $customerSupport = Role::firstOrCreate([
            'name' => 'Customer Support',
            'guard_name' => 'web',
        ]);

        $mechanicCoordinator = Role::firstOrCreate([
            'name' => 'Mechanic Coordinator',
            'guard_name' => 'web',
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'Customer',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        |
        | Super Admin is an owner / oversight role.
        |
        | It should NOT automatically receive every permission.
        | Operational changes belong to Admin.
        |
        */

        $superAdmin->syncPermissions([
            'dashboard.view',

            // Owner / statistics
            'owner.dashboard.view',
            'owner.statistics.view',
            'owner.reports.view',
            'owner.activity.view',

            // Admin account management
            'admin-users.view',
            'admin-users.create',
            'admin-users.status.update',

            // Read-only business visibility
            'customers.view',
            'vehicles.view',
            'job-cards.view',
            'job-cards-tasks.view',

            // Financial visibility
            'payments.view',
            'finance.view',
            'finance.reports.view',

            // Reports
            'reports.view',

            // Employee / payroll visibility
            'employees.view',
            'payroll.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        |
        | Admin gets full Laravel management access.
        |
        */

        $admin->syncPermissions([
            'dashboard.view',

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

            // Job Card Tasks
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            // Service Task Catalog
            'service-tasks.view',
            'service-tasks.create',
            'service-tasks.update',
            'service-tasks.status.update',

            // Service Task Parts
            'service-task-parts.view',
            'service-task-parts.create',
            'service-task-parts.remove',

            // Job Card Parts visibility / management
            'job-card-parts.view',
            'job-card-parts.request',
            'job-card-parts.create',
            'job-card-parts.update',
            'job-card-parts.remove',

            // Job Card Billing
            'job-cards.estimate.view',
            'job-cards.estimate.create',
            'job-cards.estimate.update',
            'job-cards.final-bill.view',
            'job-cards.final-bill.create',
            'job-cards.final-bill.update',

            // Payments
            'payments.view',
            'payments.create',
            'payments.update',

            // Finance
            'finance.view',
            'finance.manage',
            'finance.reports.view',

            // Reports
            'reports.view',

            // Bays
            'bays.view',
            'bays.create',
            'bays.update',
            'bays.status.update',

            // Parts
            'parts.view',
            'parts.create',
            'parts.update',
            'parts.status.update',
            'parts.manage',
            'parts.receive',
            'parts.issue',
            'parts.return',
            'parts.adjust',
            'parts.suppliers.manage',

            // General Inventory
            'inventory.view',
            'inventory.manage',
            'inventory.receive',
            'inventory.issue',
            'inventory.return',
            'inventory.adjust',

            // Bookings
            'bookings.view',
            'bookings.create',
            'bookings.update',
            'bookings.status.update',

            // Employees
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            'employees.bank-details.manage',
            'employees.salary.manage',

            'attendance.view',
            'attendance.manage',
            'attendance.check-in',
            'attendance.check-out',

            'shifts.view',
            'shifts.manage',

            'payroll.settings.manage',
            'payroll.view',
            'payroll.calculate',
            'payroll.approve',
            'payroll.payment.manage',

            'company-holidays.view',
            'company-holidays.manage',

            'leave-requests.view',
            'leave-requests.review',

            'marketing-studio.view',

            // Departments
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.status.update',

            // Roles
            'roles.view',
            'roles.create',
            'roles.update',

            // Payroll
            'payroll.view',
            'payroll.manage',

            // Settings
            'settings.view',
            'settings.update',

            // Catalog
            'catalog.view',
            'catalog.create',
            'catalog.update',
            'catalog.status.update',

            // Admin user management
            'admin-users.view',
            'admin-users.create',
            'admin-users.status.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Advisor
        |--------------------------------------------------------------------------
        |
        | Front-desk / customer-facing operational role.
        |
        | Advisor can:
        | - Manage customers
        | - Manage vehicles
        | - Create/update job cards
        | - Update job-card workflow status
        | - Add predefined tasks
        | - Prepare estimate/final bill
        |
        | Advisor cannot:
        | - Assign mechanics
        | - Assign bays
        | - Request/issue/return parts
        | - Manage inventory
        | - Manage employees
        | - Manage payroll
        | - Manage finance
        | - Manage settings
        |
        */

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

            // Job Cards
            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            // Job Card Tasks
            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',

            // Job Card Billing
            'job-cards.estimate.view',
            'job-cards.estimate.create',
            'job-cards.estimate.update',

            'job-cards.final-bill.view',
            'job-cards.final-bill.create',
            'job-cards.final-bill.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Floor Manager
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Mechanic
        |--------------------------------------------------------------------------
        */

        $mechanic->syncPermissions([
            'dashboard.view',

            'job-cards.view',
            'job-cards-tasks.view',

            'bays.view',
            'parts.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Auto Parts Store Manager
        |--------------------------------------------------------------------------
        */

        $autoPartsStoreManager->syncPermissions([
            'dashboard.view',

            'parts.view',
            'parts.manage',
            'parts.receive',
            'parts.issue',
            'parts.return',
            'parts.adjust',
            'parts.suppliers.manage',

            'job-card-parts.view',

            'catalog.view',
            'catalog.create',
            'catalog.update',
            'catalog.status.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | General Store Manager
        |--------------------------------------------------------------------------
        */

        $generalStoreManager->syncPermissions([
            'dashboard.view',

            'inventory.view',
            'inventory.manage',
            'inventory.receive',
            'inventory.issue',
            'inventory.return',
            'inventory.adjust',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customer Support
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Mechanic Coordinator
        |--------------------------------------------------------------------------
        */

        $mechanicCoordinator->syncPermissions([
            'dashboard.view',

            'employees.view',
            'departments.view',

            'customers.view',
            'vehicles.view',

            'job-cards.view',
            'job-cards.update',

            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            // Mechanic / Bay assignment
            'job-cards-tasks.assign-mechanic',
            'job-cards-tasks.assign-bay',

            // Bays
            'bays.view',
            'bays.update',

            // Parts catalog
            'parts.view',

            // Job Card Parts
            'job-card-parts.view',
            'job-card-parts.request',
            'job-card-parts.create',
            'job-card-parts.update',
            'job-card-parts.remove',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

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
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $adminUser = User::firstOrCreate(
            [
                'email' => 'admin@hitekautomobiles.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $superAdminUser->syncRoles([$superAdmin]);
        $adminUser->syncRoles([$admin]);
    }
}
