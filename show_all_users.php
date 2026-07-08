<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ALL USERS IN SYSTEM ===\n\n";

$users = App\Models\User::with('role')->get();

echo "Total Users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Role: " . ($user->role ? $user->role->nama_role : 'No Role') . "\n";
    echo "  Status: {$user->status}\n";
    echo "  Phone: " . ($user->phone ?? '-') . "\n";
    echo "\n";
}

echo "=== DEFAULT PASSWORDS (for testing) ===\n\n";
echo "Note: These are the default passwords set by seeders.\n";
echo "Please change them after first login!\n\n";

echo "1. Super Admin\n";
echo "   Email: superadmin@inventory.com\n";
echo "   Password: admin123\n\n";

echo "2. Admin\n";
echo "   Email: admin@inventory.com\n";
echo "   Password: admin123\n\n";

echo "3. Staff\n";
echo "   Email: test@example.com\n";
echo "   Password: password\n\n";
