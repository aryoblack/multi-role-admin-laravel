<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== REGENERATE COMPANY SETTINGS MENU ===\n\n";

// 1. Delete old menu and permissions
echo "Step 1: Deleting old menu and permissions...\n";

$oldMenu = App\Models\Menu::where('url', 'company-settings')->first();
if ($oldMenu) {
    // Delete permissions first
    App\Models\Permission::where('menu_id', $oldMenu->id)->delete();
    echo "  ✓ Old permissions deleted\n";
    
    // Delete menu
    $oldMenu->delete();
    echo "  ✓ Old menu deleted\n";
} else {
    echo "  - No old menu found\n";
}

echo "\n";

// 2. Create new menu
echo "Step 2: Creating new menu...\n";

$menu = App\Models\Menu::create([
    'nama_menu' => 'Pengaturan Perusahaan',
    'url' => 'company-settings',
    'icon' => 'fas fa-building',
    'parent_id' => null,
    'urutan' => 99,
]);

echo "  ✓ Menu created (ID: {$menu->id})\n";
echo "  - Name: {$menu->nama_menu}\n";
echo "  - URL: {$menu->url}\n";
echo "  - Icon: {$menu->icon}\n";

echo "\n";

// 3. Create permissions for Super Admin
echo "Step 3: Creating permissions for Super Admin...\n";

$superAdminRole = App\Models\Role::where('nama_role', 'Super Admin')->first();

if ($superAdminRole) {
    $permission = App\Models\Permission::create([
        'role_id' => $superAdminRole->id,
        'menu_id' => $menu->id,
        'can_view' => true,
        'can_add' => false,
        'can_update' => true,
        'can_delete' => false,
    ]);
    
    echo "  ✓ Permission created for Super Admin\n";
    echo "  - Can View: Yes\n";
    echo "  - Can Update: Yes\n";
} else {
    echo "  ✗ Super Admin role not found\n";
}

echo "\n";

// 4. Verify
echo "Step 4: Verification...\n";

$verifyMenu = App\Models\Menu::where('url', 'company-settings')->first();
$verifyPermission = App\Models\Permission::where('menu_id', $menu->id)->first();

if ($verifyMenu && $verifyPermission) {
    echo "  ✓ Menu exists in database\n";
    echo "  ✓ Permission exists in database\n";
    echo "\n=== SUCCESS ===\n";
} else {
    echo "  ✗ Verification failed\n";
}
