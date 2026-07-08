<?php

namespace App\Http\Controllers;

use App\Services\DatabaseBackupServiceNoZip as DatabaseBackupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;

class DatabaseBackupController extends Controller
{
    protected $backupService;

    public function __construct(DatabaseBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Display backup management page
     */
    public function index(): View
    {
        $this->ensureSuperAdmin();

        $backups = $this->backupService->getAllBackups();
        return view('backups.index', compact('backups'));
    }

    /**
     * Create new backup
     */
    public function create(): JsonResponse
    {
        $this->ensureSuperAdmin();

        try {
            $result = $this->backupService->createBackup();

            if ($result['success']) {
                Log::info('Backup created successfully', [
                    'user_id' => auth()->id(),
                    'filename' => $result['filename'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Backup berhasil dibuat!',
                    'data' => $result
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat backup'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Backup creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat backup'
            ], 500);
        }
    }

    /**
     * Download backup file
     */
    public function download(string $filename)
    {
        $this->ensureSuperAdmin();

        try {
            $filepath = $this->backupService->getBackupFilePath($filename);

            Log::info('Backup downloaded', [
                'user_id' => auth()->id(),
                'filename' => $filename,
            ]);

            return response()->download($filepath);
        } catch (\Exception $e) {
            Log::error('Backup download failed', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Gagal mengunduh backup');
        }
    }

    /**
     * Restore database from backup
     */
    public function restore(Request $request): JsonResponse
    {
        $this->ensureSuperAdmin();

        $request->validate([
            'filename' => ['required', 'string', 'regex:/\A[A-Za-z0-9._-]+\.sql\z/'],
        ]);

        try {
            $result = $this->backupService->restoreBackup($request->filename);

            if ($result['success']) {
                Log::info('Database restored successfully', [
                    'user_id' => auth()->id(),
                    'filename' => $request->filename,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal restore database'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Database restore failed', [
                'user_id' => auth()->id(),
                'filename' => $request->filename,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat restore database'
            ], 500);
        }
    }

    /**
     * Delete backup file
     */
    public function destroy(string $filename): JsonResponse
    {
        $this->ensureSuperAdmin();

        try {
            $result = $this->backupService->deleteBackup($filename);

            if ($result['success']) {
                Log::info('Backup deleted successfully', [
                    'user_id' => auth()->id(),
                    'filename' => $filename,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus backup'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Backup deletion failed', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus backup'
            ], 500);
        }
    }

    /**
     * Export backup for cPanel
     */
    public function exportCPanel(string $filename)
    {
        $this->ensureSuperAdmin();

        try {
            $result = $this->backupService->exportForCPanel($filename);

            if ($result['success']) {
                Log::info('cPanel export created', [
                    'user_id' => auth()->id(),
                    'original_file' => $filename,
                    'export_file' => $result['filename'],
                ]);

                return response()->download($result['filepath'])->deleteFileAfterSend(true);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal export untuk cPanel'
            ], 500);
        } catch (\Exception $e) {
            Log::error('cPanel export failed', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Gagal export untuk cPanel');
        }
    }

    /**
     * Upload and restore backup
     */
    public function upload(Request $request): JsonResponse
    {
        $this->ensureSuperAdmin();

        $request->validate([
            'backup_file' => 'required|file|mimes:sql|max:102400' // Max 100MB, SQL only
        ]);

        try {
            $file = $request->file('backup_file');
            $filename = 'uploaded_' . date('Y-m-d_His') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('backups', $filename);

            Log::info('Backup file uploaded', [
                'user_id' => auth()->id(),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File backup berhasil diupload!',
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            Log::error('Backup upload failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file backup'
            ], 500);
        }
    }

    private function ensureSuperAdmin(): void
    {
        if (!auth()->user()?->isSuperAdmin()) {
            if (request()->expectsJson() || request()->ajax()) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'Akses backup database hanya untuk Super Admin.',
                ], Response::HTTP_FORBIDDEN));
            }

            abort(Response::HTTP_FORBIDDEN, 'Akses backup database hanya untuk Super Admin.');
        }
    }
}
