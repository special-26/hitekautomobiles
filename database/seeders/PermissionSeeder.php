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

            // Owner / Super Admin
            'owner.dashboard.view',
            'owner.statistics.view',
            'owner.reports.view',
            'owner.activity.view',
            'owner.admins.manage',

            // Dashboard
            'dashboard.view',

            // Users


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

            // Mechanic Coordinator - Task Execution
            'job-cards-tasks.assign-mechanic',
            'job-cards-tasks.assign-bay',

            // Service Task Catalog - Admin
            'service-tasks.view',
            'service-tasks.create',
            'service-tasks.update',
            'service-tasks.status.update',

            // Service Task Suggested Parts
            'service-task-parts.view',
            'service-task-parts.create',
            'service-task-parts.remove',

            // Job Card Parts
            'job-card-parts.view',
            'job-card-parts.request',
            'job-card-parts.create',
            'job-card-parts.update',
            'job-card-parts.remove',

            // Billing
            'job-cards.estimate.create',
            'job-cards.estimate.update',
            'job-cards.final-bill.create',
            'job-cards.final-bill.update',

            // Bays
            'bays.view',
            'bays.create',
            'bays.update',
            'bays.status.update',

            // Service Status


            // Inventory


            // Auto Parts Inventory
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

            // Payments


            // Reports


            // Bookings


            // Employee Management
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.status.update',

            // Department Management
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.status.update',

            // Role Management
            'roles.view',
            'roles.create',
            'roles.update',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
