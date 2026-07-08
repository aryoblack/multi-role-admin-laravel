<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = AppSetting::first();
        $defaultFooter = '© 2026 Multi Role System. All Rights Reserved.';

        if (! $setting) {
            AppSetting::create([
                'app_name' => 'Multi Role System',
                'primary_color' => '#2563eb',
                'secondary_color' => '#1d4ed8',
                'footer_text' => $defaultFooter,
                'allow_registration' => false,
                'maintenance_mode' => false,
            ]);
        } else {
            $primaryColor = preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $setting->primary_color) && $setting->primary_color !== '#000000'
                ? $setting->primary_color
                : '#2563eb';
            $secondaryColor = preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $setting->secondary_color) && $setting->secondary_color !== '#000000'
                ? $setting->secondary_color
                : '#1d4ed8';
            $footerText = blank($setting->footer_text) || str_contains($setting->footer_text, html_entity_decode('&Acirc;') . '©')
                ? $defaultFooter
                : $setting->footer_text;

            $setting->fill([
                'app_name' => $setting->app_name ?: 'Multi Role System',
                'primary_color' => $primaryColor,
                'secondary_color' => $secondaryColor,
                'footer_text' => $footerText,
                'allow_registration' => (bool) $setting->allow_registration,
                'maintenance_mode' => (bool) $setting->maintenance_mode,
            ])->save();
        }

        // 1. Create App Settings menu
        $menu = Menu::firstOrCreate(
            ['url' => 'app-settings'],
            [
                'nama_menu' => 'Pengaturan Aplikasi',
                'icon' => 'fas fa-cog',
                'parent_id' => null,
                'urutan' => 98, // Put it near Pengaturan Perusahaan
            ]
        );

        // 2. Assign Permission to Super Admin
        $superAdminRole = Role::where('nama_role', 'Super Admin')->first();

        if ($superAdminRole && $menu) {
            Permission::firstOrCreate(
                [
                    'role_id' => $superAdminRole->id,
                    'menu_id' => $menu->id,
                ],
                [
                    'can_view' => true,
                    'can_add' => false,
                    'can_update' => true,
                    'can_delete' => false,
                ]
            );
        }

        Cache::forget('app_settings');
    }
}
