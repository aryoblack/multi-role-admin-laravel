<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create Admin role
        $adminRole = Role::firstOrCreate(
            ['nama_role' => 'Admin'],
            ['nama_role' => 'Admin']
        );

        // Check if admin user already exists
        $existingAdmin = User::where('email', 'admin@multirole.local')->first();

        if ($existingAdmin) {
            $this->command->warn('⚠ Admin user already exists!');
            $this->command->info('Email: admin@multirole.local');
            return;
        }

        // Create Admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@multirole.local',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        $this->command->info('✓ Admin user created successfully!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Email: admin@multirole.local');
        $this->command->info('Password: admin123');
        $this->command->info('Role: Admin');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
