<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Database Backup Service - Version WITHOUT ZIP
 * Use this if ZipArchive is not available
 */
class DatabaseBackupServiceNoZip
{
    /**
     * Create database backup (SQL only, no compression)
     */
    public function createBackup(): array
    {
        try {
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

            $filesize = filesize($filepath);

            Log::info('Database backup created (no compression)', [
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
                'compressed' => false,
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
            $filepath = $this->getBackupFilePath($filename);

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
                escapeshellarg($filepath)
            );

            // Execute command
            exec($command, $output, $returnVar);

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
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $filepath = $backupPath . '/' . $file;
                $backups[] = [
                    'filename' => $file,
                    'size' => $this->formatBytes(filesize($filepath)),
                    'size_bytes' => filesize($filepath),
                    'date' => \Carbon\Carbon::createFromTimestamp(filemtime($filepath))->translatedFormat('d M Y H:i'),
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
     * Export for cPanel (just copy SQL file with instructions)
     */
    public function exportForCPanel(string $filename): array
    {
        try {
            $filepath = $this->getBackupFilePath($filename);

            // Just return the SQL file directly
            // User can download it and upload to cPanel
            return [
                'success' => true,
                'filename' => $filename,
                'filepath' => $filepath,
                'message' => 'Download file SQL ini dan upload ke cPanel phpMyAdmin',
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
            && preg_match('/\A[A-Za-z0-9._-]+\.sql\z/', $filename) === 1;
    }

    private function backupDirectory(): string
    {
        return storage_path('app/backups');
    }
}


