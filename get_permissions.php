<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$permissions = \App\Models\Permission::all();
foreach ($permissions as $p) {
    echo $p->name . PHP_EOL;
}
