<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            'dashboard.view',

            /*
            |--------------------------------------------------------------------------
            | Super Admin / Owner
            |--------------------------------------------------------------------------
            */

            'owner.dashboard.view',
            'owner.statistics.view',
            'owner.reports.view',
            'owner.activity.view',

            /*
            |--------------------------------------------------------------------------
            | Admin User Management
            |--------------------------------------------------------------------------
            */

            'admin-users.view',
            'admin-users.create',
            'admin-users.status.update',

            /*
            |--------------------------------------------------------------------------
            | Customers
            |--------------------------------------------------------------------------
            */

            'customers.view',
            'customers.create',
            'customers.update',
            'customers.status.update',

            /*
            |--------------------------------------------------------------------------
            | Vehicles
            |--------------------------------------------------------------------------
            */

            'vehicles.view',
            'vehicles.create',
            'vehicles.update',
            'vehicles.status.update',

            /*
            |--------------------------------------------------------------------------
            | Job Cards
            |--------------------------------------------------------------------------
            */

            'job-cards.view',
            'job-cards.create',
            'job-cards.update',
            'job-cards.status.update',

            /*
            |--------------------------------------------------------------------------
            | Job Card Tasks
            |--------------------------------------------------------------------------
            */

            'job-cards-tasks.view',
            'job-cards-tasks.create',
            'job-cards-tasks.update',
            'job-cards-tasks.status.update',

            /*
            |--------------------------------------------------------------------------
            | Mechanic Coordinator - Task Execution
            |--------------------------------------------------------------------------
            |
            | Used by Nuxt Mechanic Coordinator.
            |
            */

            'job-cards-tasks.assign-mechanic',
            'job-cards-tasks.assign-bay',

            /*
            |--------------------------------------------------------------------------
            | Service Task Catalog
            |--------------------------------------------------------------------------
            */

            'service-tasks.view',
            'service-tasks.create',
            'service-tasks.update',
            'service-tasks.status.update',

            /*
            |--------------------------------------------------------------------------
            | Service Task Suggested Parts
            |--------------------------------------------------------------------------
            */

            'service-task-parts.view',
            'service-task-parts.create',
            'service-task-parts.remove',

            /*
            |--------------------------------------------------------------------------
            | Job Card Parts
            |--------------------------------------------------------------------------
            |
            | Used by Nuxt Mechanic Coordinator / Store Manager workflows.
            |
            */

            'job-card-parts.view',
            'job-card-parts.request',
            'job-card-parts.create',
            'job-card-parts.update',
            'job-card-parts.remove',

            /*
            |--------------------------------------------------------------------------
            | Job Card Billing
            |--------------------------------------------------------------------------
            |
            | Billing for an individual Job Card.
            |
            */

            'job-cards.estimate.view',
            'job-cards.estimate.create',
            'job-cards.estimate.update',

            'job-cards.final-bill.view',
            'job-cards.final-bill.create',
            'job-cards.final-bill.update',

            /*
            |--------------------------------------------------------------------------
            | Payments
            |--------------------------------------------------------------------------
            |
            | Payments connected with Job Cards / Customers.
            |
            */

            'payments.view',
            'payments.create',
            'payments.update',

            /*
            |--------------------------------------------------------------------------
            | Finance
            |--------------------------------------------------------------------------
            |
            | Global financial management.
            |
            */

            'finance.view',
            'finance.manage',

            /*
            |--------------------------------------------------------------------------
            | Finance Reports
            |--------------------------------------------------------------------------
            */

            'finance.reports.view',

            /*
            |--------------------------------------------------------------------------
            | Reports
            |--------------------------------------------------------------------------
            */

            'reports.view',

            /*
            |--------------------------------------------------------------------------
            | Bays
            |--------------------------------------------------------------------------
            */

            'bays.view',
            'bays.create',
            'bays.update',
            'bays.status.update',

            /*
            |--------------------------------------------------------------------------
            | Auto Parts Inventory
            |--------------------------------------------------------------------------
            |
            | Mainly used by Nuxt Auto Parts Store Manager.
            |
            */

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

            /*
            |--------------------------------------------------------------------------
            | General Inventory
            |--------------------------------------------------------------------------
            */

            'inventory.view',
            'inventory.manage',
            'inventory.receive',
            'inventory.issue',
            'inventory.return',
            'inventory.adjust',

            /*
            |--------------------------------------------------------------------------
            | Bookings
            |--------------------------------------------------------------------------
            */

            'bookings.view',
            'bookings.create',
            'bookings.update',
            'bookings.status.update',

            /*
            |--------------------------------------------------------------------------
            | Employee Management
            |--------------------------------------------------------------------------
            */

            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            // Bank account
            'employees.bank-details.manage',
            'employees.salary.manage',

            // Attendance
            'attendance.view',
            'attendance.manage',
            'attendance.check-in',
            'attendance.check-out',

            // Shifts
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

            /*
            |--------------------------------------------------------------------------
            | Department Management
            |--------------------------------------------------------------------------
            */

            'departments.view',
            'departments.create',
            'departments.update',
            'departments.status.update',

            /*
            |--------------------------------------------------------------------------
            | Role Management
            |--------------------------------------------------------------------------
            */

            'roles.view',
            'roles.create',
            'roles.update',

            /*
            |--------------------------------------------------------------------------
            | Payroll
            |--------------------------------------------------------------------------
            */

            'payroll.view',
            'payroll.manage',

            /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            */

            'settings.view',
            'settings.update',

            /*
            |--------------------------------------------------------------------------
            | Vehicle & Parts Catalog
            |--------------------------------------------------------------------------
            */

            'catalog.view',
            'catalog.create',
            'catalog.update',
            'catalog.status.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
