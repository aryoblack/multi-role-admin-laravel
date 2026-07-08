<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create Super Admin role
        $superAdminRole = Role::firstOrCreate(
            ['nama_role' => 'Super Admin'],
            ['nama_role' => 'Super Admin']
        );

        // Check if super admin user already exists
        $existingSuperAdmin = User::where('email', 'superadmin@multirole.local')->first();

        if ($existingSuperAdmin) {
            $this->command->warn('⚠ Super Admin user already exists!');
            $this->command->info('Email: superadmin@multirole.local');
            return;
        }

        // Create Super Admin user
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@multirole.local',
            'password' => Hash::make('superadmin123'),
            'role_id' => $superAdminRole->id,
            'phone' => '081234567891',
            'status' => 'active',
        ]);

        $this->command->info('✓ Super Admin user created successfully!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Email: superadmin@multirole.local');
        $this->command->info('Password: superadmin123');
        $this->command->info('Role: Super Admin');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
