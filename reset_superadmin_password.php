<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;

echo "=== RESET SUPER ADMIN PASSWORD ===\n\n";

// Find Super Admin user
$superAdmin = App\Models\User::whereHas('role', function($q) {
    $q->where('nama_role', 'Super Admin');
})->first();

if (!$superAdmin) {
    echo "✗ Super Admin user not found!\n";
    exit(1);
}

echo "Super Admin Found:\n";
echo "  - ID: {$superAdmin->id}\n";
echo "  - Name: {$superAdmin->name}\n";
echo "  - Email: {$superAdmin->email}\n";
echo "  - Role: {$superAdmin->role->nama_role}\n";
echo "\n";

// Generate new password
$newPassword = 'admin123';

// Update password
$superAdmin->password = Hash::make($newPassword);
$superAdmin->save();

echo "✓ Password has been reset!\n\n";
echo "=== NEW CREDENTIALS ===\n";
echo "Email: {$superAdmin->email}\n";
echo "Password: {$newPassword}\n";
echo "\n";
echo "Please save these credentials in a secure place!\n";
echo "=========================\n";
