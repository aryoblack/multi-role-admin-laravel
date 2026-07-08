<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menus = \App\Models\Menu::all();
foreach ($menus as $m) {
    echo $m->id . ' | ' . $m->nama_menu . ' | ' . $m->url . ' | parent: ' . $m->parent_id . PHP_EOL;
}
