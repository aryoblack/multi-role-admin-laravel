<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class UserManagementMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing User Management menus if any
        DB::table('menus')->where('nama_menu', 'User Management')->delete();
        
        // Create Parent Menu: User Management
        $userManagement = Menu::create([
            'nama_menu' => 'User Management',
            'url' => '#',
            'icon' => 'fas fa-users-cog',
            'parent_id' => null,
            'urutan' => 3
        ]);

        // Create Submenu: Users
        Menu::create([
            'nama_menu' => 'Users',
            'url' => '/users',
            'icon' => 'fas fa-user',
            'parent_id' => $userManagement->id,
            'urutan' => 1
        ]);

        // Create Submenu: Roles
        Menu::create([
            'nama_menu' => 'Roles',
            'url' => '/roles',
            'icon' => 'fas fa-user-shield',
            'parent_id' => $userManagement->id,
            'urutan' => 2
        ]);

        // Create Submenu: Menus
        Menu::create([
            'nama_menu' => 'Menus',
            'url' => '/menus',
            'icon' => 'fas fa-bars',
            'parent_id' => $userManagement->id,
            'urutan' => 3
        ]);

        $this->command->info('✓ User Management menu with submenus created successfully!');
    }
}
