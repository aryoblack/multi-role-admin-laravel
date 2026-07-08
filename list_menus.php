<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

$menus = Menu::orderBy('urutan')->get();
foreach ($menus as $m) {
    echo "ID: {$m->id} | Name: {$m->nama_menu} | URL: {$m->url} | Parent: " . ($m->parent_id ?: 'Root') . "\n";
}
