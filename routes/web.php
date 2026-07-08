<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        $landingPage = \App\Models\Menu::getLandingPage(Illuminate\Support\Facades\Auth::user());
        return redirect($landingPage);
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('login.post')
        ->middleware('throttle:5,1'); // 5 attempts per minute
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index'); // Placeholder
    })->name('dashboard');

    // Profile Settings (Accessible to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['permission'])->group(function () {
        // User Management
        Route::resource('users', UserController::class);

        // Menu Management
        Route::resource('menus', MenuController::class)->except(['show']);

        // Role Management
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

        // Company Settings
        Route::get('company-settings', [CompanySettingController::class, 'index'])->name('company-settings.index');
        Route::put('company-settings', [CompanySettingController::class, 'update'])->name('company-settings.update');

        // App Settings
        Route::get('app-settings', [\App\Http\Controllers\AppSettingController::class, 'index'])->name('app-settings.index');
        Route::put('app-settings', [\App\Http\Controllers\AppSettingController::class, 'update'])->name('app-settings.update');

        // Database Backup
        Route::get('backups', [DatabaseBackupController::class, 'index'])->name('backups.index');
        Route::post('backups/create', [DatabaseBackupController::class, 'create'])->name('backups.create');
        Route::get('backups/download/{filename}', [DatabaseBackupController::class, 'download'])->name('backups.download')->where('filename', '[A-Za-z0-9._-]+\.sql');
        Route::post('backups/restore', [DatabaseBackupController::class, 'restore'])->name('backups.restore');
        Route::delete('backups/{filename}', [DatabaseBackupController::class, 'destroy'])->name('backups.destroy')->where('filename', '[A-Za-z0-9._-]+\.sql');
        Route::get('backups/export-cpanel/{filename}', [DatabaseBackupController::class, 'exportCPanel'])->name('backups.export-cpanel')->where('filename', '[A-Za-z0-9._-]+\.sql');
        Route::post('backups/upload', [DatabaseBackupController::class, 'upload'])->name('backups.upload');
    });
});
