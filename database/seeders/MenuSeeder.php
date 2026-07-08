<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->updateOrInsert(
            ['url' => '/dashboard'],
            [
                'nama_menu' => 'Dashboard',
                'icon' => 'fas fa-home',
                'parent_id' => null,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
