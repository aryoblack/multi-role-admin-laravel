<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::query()->firstOrCreate(
            [],
            [
                'company_name' => 'Multi Role System',
                'company_address' => 'Jl. Contoh No. 123, Jakarta',
                'company_phone' => '021-12345678',
                'company_email' => 'admin@multirole.local',
                'company_website' => null,
                'company_logo' => null,
                'company_description' => 'Aplikasi manajemen multi-role dan hak akses pengguna.',
            ]
        );
    }
}
