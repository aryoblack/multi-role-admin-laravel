<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = DB::table('roles')->pluck('id', 'nama_role');
        $menus = DB::table('menus')->pluck('id');

        foreach ($roles as $roleName => $roleId) {
            foreach ($menus as $menuId) {
                $permission = [
                    'can_view' => 0,
                    'can_add' => 0,
                    'can_update' => 0,
                    'can_delete' => 0,
                    'updated_at' => now(),
                ];

                if ($roleName === 'Super Admin') {
                    $permission['can_view'] = 1;
                    $permission['can_add'] = 1;
                    $permission['can_update'] = 1;
                    $permission['can_delete'] = 1;
                }

                if ($roleName === 'Admin') {
                    $permission['can_view'] = 1;
                    $permission['can_add'] = 1;
                    $permission['can_update'] = 1;
                }

                DB::table('permissions')->updateOrInsert(
                    [
                        'role_id' => $roleId,
                        'menu_id' => $menuId,
                    ],
                    $permission + ['created_at' => now()]
                );
            }
        }
    }
}
