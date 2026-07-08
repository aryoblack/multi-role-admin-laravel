<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING COMPANY BRANDING ===\n\n";

// Get company settings
$companySetting = App\Models\CompanySetting::first();

if ($companySetting) {
    echo "✓ Company Settings Found\n\n";
    
    echo "BRANDING INFORMATION:\n";
    echo "  Company Name: {$companySetting->company_name}\n";
    echo "  Logo: " . ($companySetting->company_logo ? "✓ Set ({$companySetting->company_logo})" : "✗ Not set") . "\n";
    echo "  Description: " . ($companySetting->company_description ? "✓ Set" : "✗ Not set") . "\n";
    
    echo "\n";
    echo "DISPLAY PREVIEW:\n";
    echo "  Login Title: Login - {$companySetting->company_name}\n";
    echo "  Page Title: {$companySetting->company_name}\n";
    echo "  Sidebar Header: {$companySetting->company_name}\n";
    
    if ($companySetting->company_logo) {
        $logoPath = storage_path('app/public/' . $companySetting->company_logo);
        if (file_exists($logoPath)) {
            echo "  Logo File: ✓ Exists at {$logoPath}\n";
            echo "  Logo Size: " . round(filesize($logoPath) / 1024, 2) . " KB\n";
        } else {
            echo "  Logo File: ✗ Not found at {$logoPath}\n";
        }
    }
    
    echo "\n";
    echo "FALLBACK TEST:\n";
    echo "  If no logo: Icon 'fas fa-building' will be shown\n";
    echo "  If no name: '" . config('app.name') . "' will be shown\n";
    echo "  If no description: Default text will be shown\n";
    
} else {
    echo "✗ No company settings found\n";
    echo "\nFALLBACK MODE:\n";
    echo "  App Name: " . config('app.name') . "\n";
    echo "  Logo: Icon 'fas fa-building'\n";
    echo "  Description: Default text\n";
}

echo "\n=== BRANDING TEST COMPLETE ===\n";
echo "\nTo update branding:\n";
echo "1. Login as Super Admin\n";
echo "2. Go to 'Pengaturan Perusahaan'\n";
echo "3. Update company information and logo\n";
echo "4. Save and refresh browser\n";
