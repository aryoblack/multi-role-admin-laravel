<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Core multi-role data only.
        $this->call([
            RoleSeeder::class,
            MenuSeeder::class,
            UserManagementMenuSeeder::class,
            CompanySettingMenuSeeder::class,
            DatabaseBackupMenuSeeder::class,
            AppSettingSeeder::class,
            CompanySettingSeeder::class,
            SuperAdminUserSeeder::class,
            SuperAdminPermissionSeeder::class,
        ]);
    }
}
