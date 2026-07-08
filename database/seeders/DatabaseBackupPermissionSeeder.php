<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseBackupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Backup Database menu
        $backupMenu = Menu::where('nama_menu', 'Backup Database')->first();

        if (!$backupMenu) {
            $this->command->error('Menu Backup Database tidak ditemukan. Jalankan DatabaseBackupMenuSeeder terlebih dahulu.');
            return;
        }

        // Get Super Admin role
        $superAdminRole = Role::where('nama_role', 'Super Admin')->first();

        if (!$superAdminRole) {
            $this->command->error('Role Super Admin tidak ditemukan.');
            return;
        }

        // Create permission for Super Admin to access all backup features
        Permission::create([
            'role_id' => $superAdminRole->id,
            'menu_id' => $backupMenu->id,
            'can_view' => true,
            'can_add' => true,
            'can_update' => true,
            'can_delete' => true,
        ]);

        $this->command->info('Permission untuk Backup Database berhasil dibuat dan di-assign ke Super Admin.');
    }
}
