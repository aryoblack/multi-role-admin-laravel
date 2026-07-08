<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== COMPANY SETTINGS TEST ===\n\n";

// Check Company Settings
$setting = App\Models\CompanySetting::first();
if ($setting) {
    echo "✓ Company Settings Found:\n";
    echo "  - Name: {$setting->company_name}\n";
    echo "  - Address: {$setting->company_address}\n";
    echo "  - Phone: {$setting->company_phone}\n";
    echo "  - Email: {$setting->company_email}\n";
    echo "  - Website: {$setting->company_website}\n";
    echo "  - Logo: " . ($setting->company_logo ? $setting->company_logo : 'Not set') . "\n";
} else {
    echo "✗ No company settings found\n";
}

echo "\n";

// Check Menu
$menu = App\Models\Menu::where('url', 'company-settings')->first();
if ($menu) {
    echo "✓ Company Settings Menu Found:\n";
    echo "  - Name: {$menu->nama_menu}\n";
    echo "  - URL: {$menu->url}\n";
    echo "  - Icon: {$menu->icon}\n";
} else {
    echo "✗ Company Settings menu not found\n";
}

echo "\n";

// Check Permission
$permission = App\Models\Permission::whereHas('menu', function($q) {
    $q->where('url', 'company-settings');
})->first();

if ($permission) {
    echo "✓ Company Settings Permission Found:\n";
    echo "  - Role: {$permission->role->nama_role}\n";
    echo "  - Can View: " . ($permission->can_view ? 'Yes' : 'No') . "\n";
    echo "  - Can Update: " . ($permission->can_update ? 'Yes' : 'No') . "\n";
} else {
    echo "✗ Company Settings permission not found\n";
}

echo "\n=== TEST COMPLETE ===\n";
