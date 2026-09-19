<?php

namespace Database\Seeders;

use Database\Seeders\AdminCreateSeeder;
use Database\Seeders\DevelopmentSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::firstOrCreate(
        //     ['email' => 'test@example.com'],
        //     [
        //         'name' => 'Test User',
        //         'password' => 'password',
        //         'email_verified_at' => now(),
        //     ]
        // );

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminCreateSeeder::class,
            PartCategorySeeder::class,
            AssignPartCategoriesSeeder::class,
            PartSeeder::class,
            VehicleCatalogSeeder::class,
        ]);
    }
}
