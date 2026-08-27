<?php

namespace App\Console\Commands;

use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Console\Command;

class SeedRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:rnp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the RoleSeeder and PermissionSeeder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting role and permission seeding...');

        // Resolves and runs the seeders natively
        app(PermissionSeeder::class)->run();
        app(RoleSeeder::class)->run();

        $this->info('Roles and permissions seeded successfully!');
    }
}
