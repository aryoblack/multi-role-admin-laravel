<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        foreach (['Super Admin', 'Admin', 'Staff'] as $roleName) {
            DB::table('roles')->updateOrInsert(
                ['nama_role' => $roleName],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
