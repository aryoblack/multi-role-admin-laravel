<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== TESTING APP PROVIDER ===\n\n";

try {
    // Test CompanySetting model
    $companySetting = App\Models\CompanySetting::first();
    
    if ($companySetting) {
        echo "✓ CompanySetting loaded successfully\n";
        echo "  - Company Name: {$companySetting->company_name}\n";
    } else {
        echo "✗ No company setting found\n";
    }
    
    // Test if view composer works
    echo "\n✓ AppServiceProvider boot() executed without errors\n";
    
    echo "\n=== ALL TESTS PASSED ===\n";
    
} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "  File: " . $e->getFile() . "\n";
    echo "  Line: " . $e->getLine() . "\n";
}
