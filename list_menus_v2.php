<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

$menus = Menu::orderBy('urutan')->get();
$output = "";
foreach ($menus as $m) {
    $parent = $m->parent_id ?: 'Root';
    $output .= "ID: {$m->id} | Name: {$m->nama_menu} | URL: {$m->url} | Parent: {$parent}\n";
}
file_put_contents('menu_list.txt', $output);
echo "Done\n";
