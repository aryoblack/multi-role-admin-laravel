<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ALL MENUS IN DATABASE ===\n\n";

$menus = App\Models\Menu::orderBy('urutan')->get();

echo "Total Menus: " . $menus->count() . "\n\n";

foreach ($menus as $menu) {
    $permissions = App\Models\Permission::where('menu_id', $menu->id)->count();
    $parent = $menu->parent_id ? App\Models\Menu::find($menu->parent_id)->nama_menu : 'Root';
    
    echo "ID: {$menu->id}\n";
    echo "  Name: {$menu->nama_menu}\n";
    echo "  URL: {$menu->url}\n";
    echo "  Icon: {$menu->icon}\n";
    echo "  Parent: {$parent}\n";
    echo "  Order: {$menu->urutan}\n";
    echo "  Permissions: {$permissions}\n";
    echo "\n";
}

echo "=== COMPANY SETTINGS MENU DETAILS ===\n\n";

$companyMenu = App\Models\Menu::where('url', 'company-settings')->first();

if ($companyMenu) {
    echo "✓ Company Settings Menu Found\n";
    echo "  ID: {$companyMenu->id}\n";
    echo "  Name: {$companyMenu->nama_menu}\n";
    echo "  URL: {$companyMenu->url}\n";
    
    $permissions = App\Models\Permission::where('menu_id', $companyMenu->id)->get();
    echo "\n  Permissions:\n";
    foreach ($permissions as $perm) {
        $role = App\Models\Role::find($perm->role_id);
        echo "    - Role: {$role->nama_role}\n";
        echo "      View: " . ($perm->can_view ? 'Yes' : 'No') . "\n";
        echo "      Add: " . ($perm->can_add ? 'Yes' : 'No') . "\n";
        echo "      Update: " . ($perm->can_update ? 'Yes' : 'No') . "\n";
        echo "      Delete: " . ($perm->can_delete ? 'Yes' : 'No') . "\n";
    }
} else {
    echo "✗ Company Settings Menu NOT Found\n";
}
