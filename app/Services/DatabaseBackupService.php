<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DatabaseBackupService
{
    /**
     * Create database backup
     */
    public function createBackup(): array
    {
        try {
            // Check if ZipArchive is available
            if (!class_exists('ZipArchive')) {
                throw new \Exception('PHP Zip extension tidak aktif. Silakan aktifkan extension=zip di php.ini dan restart Laragon.');
            }

            $filename = 'backup_' . date('Y-m-d_His') . '.sql';
            $filepath = storage_path('app/backups/' . $filename);

            // Create backups directory if not exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($database),
                escapeshellarg($filepath)
            );

            // Execute command
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('Backup failed with return code: ' . $returnVar);
            }

            // Compress the backup
            $zipFilename = 'backup_' . date('Y-m-d_His') . '.zip';
            $zipFilepath = storage_path('app/backups/' . $zipFilename);
            
            $zip = new ZipArchive();
            if ($zip->open($zipFilepath, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($filepath, $filename);
                $zip->close();
                
                // Delete uncompressed SQL file
                unlink($filepath);
                
                $filepath = $zipFilepath;
                $filename = $zipFilename;
            }

            $filesize = filesize($filepath);

            Log::info('Database backup created', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'size' => $filesize,
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'filepath' => $filepath,
                'size' => $this->formatBytes($filesize),
                'size_bytes' => $filesize,
            ];
        } catch (\Exception $e) {
            Log::error('Database backup failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Operasi backup database gagal diproses.',
            ];
        }
    }

    /**
     * Restore database from backup
     */
    public function restoreBackup(string $filename): array
    {
        try {
            // Check if ZipArchive is available for zip files
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'zip' && !class_exists('ZipArchive')) {
                throw new \Exception('PHP Zip extension tidak aktif. Silakan aktifkan extension=zip di php.ini dan restart Laragon.');
            }

            $filepath = $this->getBackupFilePath($filename);

            // Extract if zip file
            $sqlFile = $filepath;
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'zip') {
                $zip = new ZipArchive();
                if ($zip->open($filepath) === TRUE) {
                    $extractPath = storage_path('app/backups/temp/');
                    if (!file_exists($extractPath)) {
                        mkdir($extractPath, 0755, true);
                    }
                    
                    $zip->extractTo($extractPath);
                    $zip->close();
                    
                    // Find SQL file
                    $files = glob($extractPath . '*.sql');
                    if (empty($files)) {
                        throw new \Exception('No SQL file found in backup');
                    }
                    $sqlFile = $files[0];
                }
            }

            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);

            // Build mysql command
            $command = sprintf(
                'mysql --user=%s --password=%s --host=%s --port=%s %s < %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($database),
                escapeshellarg($sqlFile)
            );

            // Execute command
            exec($command, $output, $returnVar);

            // Clean up temp files
            if ($sqlFile !== $filepath && file_exists($sqlFile)) {
                unlink($sqlFile);
                rmdir(dirname($sqlFile));
            }

            if ($returnVar !== 0) {
                throw new \Exception('Restore failed with return code: ' . $returnVar);
            }

            Log::info('Database restored', [
                'user_id' => auth()->id(),
                'filename' => $filename,
            ]);

            return [
                'success' => true,
                'message' => 'Database berhasil di-restore',
            ];
        } catch (\Exception $e) {
            Log::error('Database restore failed', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Operasi backup database gagal diproses.',
            ];
        }
    }

    /**
     * Get all backups
     */
    public function getAllBackups(): array
    {
        $backupPath = storage_path('app/backups');
        
        if (!file_exists($backupPath)) {
            return [];
        }

        $files = array_diff(scandir($backupPath), ['.', '..', 'temp']);
        $backups = [];

        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['sql', 'zip'])) {
                $filepath = $backupPath . '/' . $file;
                $backups[] = [
                    'filename' => $file,
                    'size' => $this->formatBytes(filesize($filepath)),
                    'size_bytes' => filesize($filepath),
                    'date' => date('Y-m-d H:i:s', filemtime($filepath)),
                    'timestamp' => filemtime($filepath),
                ];
            }
        }

        // Sort by timestamp descending
        usort($backups, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return $backups;
    }

    /**
     * Delete backup
     */
    public function deleteBackup(string $filename): array
    {
        try {
            $filepath = $this->getBackupFilePath($filename);

            unlink($filepath);

            Log::info('Backup deleted', [
                'user_id' => auth()->id(),
                'filename' => $filename,
            ]);

            return [
                'success' => true,
                'message' => 'Backup berhasil dihapus',
            ];
        } catch (\Exception $e) {
            Log::error('Backup deletion failed', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Operasi backup database gagal diproses.',
            ];
        }
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Export backup for cPanel (with instructions)
     */
    public function exportForCPanel(string $filename): array
    {
        try {
            // Check if ZipArchive is available
            if (!class_exists('ZipArchive')) {
                throw new \Exception('PHP Zip extension tidak aktif. Silakan aktifkan extension=zip di php.ini dan restart Laragon.');
            }

            $filepath = $this->getBackupFilePath($filename);

            // Create instructions file
            $instructions = $this->getCPanelInstructions();
            $instructionsFile = storage_path('app/backups/CPANEL_IMPORT_INSTRUCTIONS.txt');
            file_put_contents($instructionsFile, $instructions);

            // Create zip with backup and instructions
            $exportFilename = 'cpanel_export_' . date('Y-m-d_His') . '.zip';
            $exportPath = storage_path('app/backups/' . $exportFilename);

            $zip = new ZipArchive();
            if ($zip->open($exportPath, ZipArchive::CREATE) === TRUE) {
                // Add backup file
                if (pathinfo($filename, PATHINFO_EXTENSION) === 'zip') {
                    // Extract SQL from zip
                    $tempZip = new ZipArchive();
                    if ($tempZip->open($filepath) === TRUE) {
                        $tempPath = storage_path('app/backups/temp/');
                        if (!file_exists($tempPath)) {
                            mkdir($tempPath, 0755, true);
                        }
                        $tempZip->extractTo($tempPath);
                        $tempZip->close();
                        
                        $sqlFiles = glob($tempPath . '*.sql');
                        if (!empty($sqlFiles)) {
                            $zip->addFile($sqlFiles[0], basename($sqlFiles[0]));
                            unlink($sqlFiles[0]);
                        }
                        rmdir($tempPath);
                    }
                } else {
                    $zip->addFile($filepath, $filename);
                }
                
                // Add instructions
                $zip->addFile($instructionsFile, 'CPANEL_IMPORT_INSTRUCTIONS.txt');
                $zip->close();
            }

            // Clean up instructions file
            unlink($instructionsFile);

            return [
                'success' => true,
                'filename' => $exportFilename,
                'filepath' => $exportPath,
            ];
        } catch (\Exception $e) {
            Log::error('cPanel export failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Operasi backup database gagal diproses.',
            ];
        }
    }

    /**
     * Get cPanel import instructions
     */
    private function getCPanelInstructions(): string
    {
        return <<<EOT
=================================================================
CARA IMPORT DATABASE KE CPANEL
=================================================================

1. LOGIN KE CPANEL
   - Buka browser dan akses cPanel Anda
   - Login dengan username dan password cPanel

2. BUKA PHPMYADMIN
   - Cari menu "phpMyAdmin" di cPanel
   - Klik untuk membuka phpMyAdmin

3. PILIH DATABASE
   - Di sidebar kiri, klik nama database Anda
   - Jika belum ada, buat database baru terlebih dahulu

4. IMPORT DATABASE
   - Klik tab "Import" di bagian atas
   - Klik tombol "Choose File" atau "Browse"
   - Pilih file .sql yang ada di dalam zip ini
   - Scroll ke bawah dan klik tombol "Go" atau "Import"

5. TUNGGU PROSES SELESAI
   - Tunggu hingga muncul pesan "Import has been successfully finished"
   - Jika ada error, cek ukuran file (max 50MB di phpMyAdmin)

6. VERIFIKASI
   - Cek tabel-tabel di sidebar kiri
   - Pastikan semua tabel sudah ter-import

=================================================================
TROUBLESHOOTING
=================================================================

JIKA FILE TERLALU BESAR:
1. Gunakan "MySQL Databases" di cPanel
2. Atau gunakan SSH dengan command:
   mysql -u username -p database_name < backup.sql

JIKA ADA ERROR "MAX_ALLOWED_PACKET":
1. Split file SQL menjadi beberapa bagian
2. Atau hubungi hosting provider untuk increase limit

JIKA ADA ERROR "DUPLICATE ENTRY":
1. Drop semua tabel terlebih dahulu
2. Atau gunakan option "DROP TABLE IF EXISTS"

=================================================================
KONFIGURASI .ENV DI SERVER
=================================================================

Setelah import database, update file .env di server:

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda

Kemudian jalankan:
php artisan config:clear
php artisan cache:clear

=================================================================
SUPPORT
=================================================================

Jika mengalami kesulitan, hubungi:
- Hosting provider Anda
- Administrator sistem

Backup dibuat pada: {date}
Database: {database}

=================================================================
EOT;
    }

    /**
     * Resolve a backup filename to a safe absolute path inside storage/app/backups.
     */
    public function getBackupFilePath(string $filename): string
    {
        if (!$this->isValidBackupFilename($filename)) {
            throw new \Exception('Invalid backup filename');
        }

        $backupPath = realpath($this->backupDirectory());
        if ($backupPath === false) {
            throw new \Exception('Backup directory not found');
        }

        $filepath = realpath($backupPath . DIRECTORY_SEPARATOR . $filename);
        if ($filepath === false || !is_file($filepath)) {
            throw new \Exception('Backup file not found');
        }

        if (!str_starts_with($filepath, $backupPath . DIRECTORY_SEPARATOR)) {
            throw new \Exception('Invalid backup path');
        }

        return $filepath;
    }

    private function isValidBackupFilename(string $filename): bool
    {
        return basename($filename) === $filename
            && preg_match('/\A[A-Za-z0-9._-]+\.(sql|zip)\z/', $filename) === 1;
    }

    private function backupDirectory(): string
    {
        return storage_path('app/backups');
    }
}


