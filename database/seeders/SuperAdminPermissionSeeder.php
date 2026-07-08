<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Super Admin role
        $superAdminRole = Role::where('nama_role', 'Super Admin')->first();

        if (!$superAdminRole) {
            $this->command->error('✗ Super Admin role not found!');
            $this->command->info('Please run SuperAdminUserSeeder first.');
            return;
        }

        // Get all menus
        $menus = Menu::all();

        if ($menus->isEmpty()) {
            $this->command->error('✗ No menus found!');
            $this->command->info('Please run menu seeders first.');
            return;
        }

        // Delete existing permissions for Super Admin
        Permission::where('role_id', $superAdminRole->id)->delete();

        $permissionsCreated = 0;

        // Create full permissions for Super Admin on all menus
        foreach ($menus as $menu) {
            Permission::create([
                'role_id' => $superAdminRole->id,
                'menu_id' => $menu->id,
                'can_view' => 1,
                'can_add' => 1,
                'can_update' => 1,
                'can_delete' => 1,
            ]);
            $permissionsCreated++;
        }

        $this->command->info('✓ Super Admin permissions created successfully!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info("Role: {$superAdminRole->nama_role}");
        $this->command->info("Total Menus: {$menus->count()}");
        $this->command->info("Permissions Created: {$permissionsCreated}");
        $this->command->info('Access Level: FULL (View, Add, Update, Delete)');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        // Display menu list
        $this->command->info("\nMenus with Full Access:");
        foreach ($menus as $index => $menu) {
            $this->command->info(($index + 1) . ". {$menu->nama_menu}");
        }
    }
}
