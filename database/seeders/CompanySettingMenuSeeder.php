<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class CompanySettingMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::updateOrCreate(
            ['url' => 'company-settings'],
            [
                'nama_menu' => 'Pengaturan Perusahaan',
                'icon' => 'fas fa-building',
                'parent_id' => null,
                'urutan' => 99,
            ]
        );
    }
}
