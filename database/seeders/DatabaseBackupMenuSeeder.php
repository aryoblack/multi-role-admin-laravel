<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseBackupMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::updateOrCreate(
            ['url' => '/backups'],
            [
                'nama_menu' => 'Backup Database',
                'icon' => 'fas fa-database',
                'parent_id' => null,
                'urutan' => 5,
            ]
        );
    }
}
