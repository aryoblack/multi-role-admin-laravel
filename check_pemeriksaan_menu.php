<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING PEMERIKSAAN MENU ===\n\n";

// Check menu
$menu = App\Models\Menu::where('nama_menu', 'Pemeriksaan')->first();

if ($menu) {
    echo "✓ Menu found!\n";
    echo "  ID: {$menu->id}\n";
    echo "  Name: {$menu->nama_menu}\n";
    echo "  URL: {$menu->url}\n";
    echo "  Icon: {$menu->icon}\n";
    echo "  Parent: " . ($menu->parent ? $menu->parent->nama_menu : 'None') . "\n";
    echo "  Order: {$menu->urutan}\n\n";
    
    // Check permission
    $permission = App\Models\Permission::where('menu_id', $menu->id)->first();
    if ($permission) {
        echo "✓ Permission found!\n";
        echo "  Role: {$permission->role->name}\n";
        echo "  Can View: " . ($permission->can_view ? 'Yes' : 'No') . "\n";
        echo "  Can Add: " . ($permission->can_add ? 'Yes' : 'No') . "\n";
        echo "  Can Update: " . ($permission->can_update ? 'Yes' : 'No') . "\n";
        echo "  Can Delete: " . ($permission->can_delete ? 'Yes' : 'No') . "\n";
    } else {
        echo "✗ Permission NOT FOUND\n";
    }
} else {
    echo "✗ Menu NOT FOUND in database\n";
    echo "\nPlease run: php artisan db:seed --class=ResetInventoryMenuSeeder\n";
}

echo "\n=== ALL TRANSAKSI SUBMENUS ===\n\n";

$transaksi = App\Models\Menu::where('nama_menu', 'Transaksi')->first();
if ($transaksi) {
    $submenus = App\Models\Menu::where('parent_id', $transaksi->id)
        ->orderBy('urutan')
        ->get();
    
    echo "Found " . $submenus->count() . " submenus:\n";
    foreach ($submenus as $submenu) {
        echo "  {$submenu->urutan}. {$submenu->nama_menu} ({$submenu->url})\n";
    }
} else {
    echo "✗ Transaksi menu not found\n";
}

echo "\n";
