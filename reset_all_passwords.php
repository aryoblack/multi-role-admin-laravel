<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;

echo "=== RESET ALL USER PASSWORDS ===\n\n";

// Define default passwords for each role
$passwords = [
    'Super Admin' => 'admin123',
    'Admin' => 'admin123',
    'Staff' => 'password',
];

$users = App\Models\User::with('role')->get();

echo "Total Users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    $roleName = $user->role ? $user->role->nama_role : 'No Role';
    $newPassword = $passwords[$roleName] ?? 'password';
    
    // Update password
    $user->password = Hash::make($newPassword);
    $user->save();
    
    echo "✓ {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Role: {$roleName}\n";
    echo "  New Password: {$newPassword}\n";
    echo "\n";
}

echo "=== ALL PASSWORDS RESET ===\n\n";

echo "Summary:\n";
echo "  Super Admin: admin123\n";
echo "  Admin: admin123\n";
echo "  Staff: password\n";
echo "\n";
echo "⚠️  Please change these passwords after first login!\n";
