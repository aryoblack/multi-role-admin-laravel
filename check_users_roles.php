<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING USER & ROLE MANAGEMENT ===\n\n";

// Check Roles
echo "ROLES:\n";
$roles = App\Models\Role::all();
echo "Total Roles: " . $roles->count() . "\n";
foreach ($roles as $role) {
    $userCount = $role->users()->count();
    echo "  - {$role->nama_role} (ID: {$role->id}) - {$userCount} users\n";
}

echo "\n";

// Check Users
echo "USERS:\n";
$users = App\Models\User::with('role')->get();
echo "Total Users: " . $users->count() . "\n";
foreach ($users as $user) {
    $roleName = $user->role ? $user->role->nama_role : 'No Role';
    echo "  - {$user->name} ({$user->email}) - Role: {$roleName} - Status: {$user->status}\n";
}

echo "\n=== DATABASE CONNECTION ===\n";
echo "Host: " . config('database.connections.mysql.host') . "\n";
echo "Port: " . config('database.connections.mysql.port') . "\n";
echo "Database: " . config('database.connections.mysql.database') . "\n";
echo "Connection: SUCCESS\n";
