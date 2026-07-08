<?php
// Check if Zip extension is loaded in web server
header('Content-Type: application/json');

$result = [
    'php_version' => PHP_VERSION,
    'sapi' => php_sapi_name(),
    'zip_class_exists' => class_exists('ZipArchive'),
    'zip_extension_loaded' => extension_loaded('zip'),
    'loaded_extensions' => get_loaded_extensions(),
];

// Check if zip is in the list
$result['zip_in_extensions'] = in_array('zip', $result['loaded_extensions']);

// Get php.ini location
$result['php_ini'] = php_ini_loaded_file();
$result['additional_ini'] = php_ini_scanned_files();

// Status
if ($result['zip_class_exists'] && $result['zip_extension_loaded']) {
    $result['status'] = 'OK';
    $result['message'] = 'Zip extension is properly loaded!';
} else {
    $result['status'] = 'ERROR';
    $result['message'] = 'Zip extension is NOT loaded in web server!';
    $result['solution'] = [
        '1. Stop Laragon (Right-click → Stop All)',
        '2. Edit php.ini: ' . $result['php_ini'],
        '3. Find: ;extension=zip',
        '4. Change to: extension=zip',
        '5. Save file',
        '6. Start Laragon (Right-click → Start All)',
        '7. Refresh this page',
    ];
}

echo json_encode($result, JSON_PRETTY_PRINT);
