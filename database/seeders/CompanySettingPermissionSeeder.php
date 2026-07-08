<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CompanySettingPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Super Admin role
        $superAdminRole = Role::where('nama_role', 'Super Admin')->first();
        
        // Get Company Settings menu
        $companySettingMenu = Menu::where('url', 'company-settings')->first();
        
        if ($superAdminRole && $companySettingMenu) {
            // Create permission for Super Admin
            Permission::create([
                'role_id' => $superAdminRole->id,
                'menu_id' => $companySettingMenu->id,
                'can_view' => true,
                'can_add' => false,
                'can_update' => true,
                'can_delete' => false,
            ]);
        }
    }
}
