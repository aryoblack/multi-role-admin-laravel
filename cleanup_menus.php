<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CLEANING UP ALL INVENTORY MENUS ===\n\n";

// Delete ALL menus related to inventory
$menuNames = [
    'Inventory Management',
    'Manajemen Inventory',
    'Data Master',
    'Kategori',
    'Lokasi',
    'Vendor',
    'Data Item',
    'Scan QR Code',
    'Procurement'
];

$allMenuIds = App\Models\Menu::whereIn('nama_menu', $menuNames)->pluck('id');

echo "Found " . $allMenuIds->count() . " menus to delete\n";

// Delete permissions first
$deletedPerms = App\Models\Permission::whereIn('menu_id', $allMenuIds)->delete();
echo "Deleted {$deletedPerms} permissions\n";

// Delete menus
$deletedMenus = App\Models\Menu::whereIn('id', $allMenuIds)->delete();
echo "Deleted {$deletedMenus} menus\n";

echo "\n✅ Cleanup complete!\n";
echo "\nNow run: php artisan db:seed --class=ResetInventoryMenuSeeder\n";
