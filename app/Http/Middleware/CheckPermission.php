<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 3. Dapatkan Path URL saat ini
        // Contoh: /users/create -> users
        // Contoh: /users/1/edit -> users
        $currentPath = '/' . trim($request->path(), '/');
        $cacheVersion = (int) Cache::get('permission_cache_version', 1);

        // Cari menu yang URL-nya cocok dengan path saat ini
        // Kita loop semua menu untuk mencari yang paling spesifik atau cocok
        // Menggunakan query database sederhana untuk mencari menu yang URL-nya terkandung dalam current path
        // Asumsi: URL di menu adalah prefix valid (misal: /users)

        // Ambil semua menu yang memiliki URL (bukan parent kosong)
        $menus = Cache::remember("permission_menus:v{$cacheVersion}", 3600, function () {
            return Menu::whereNotNull('url')
                ->where('url', '!=', '#')
                ->get(['id', 'url']);
        });

        $currentMenu = null;
        foreach ($menus as $menu) {
            $menuUrl = '/' . trim($menu->url, '/');

            if ($menuUrl !== '/' && $this->pathMatchesMenu($currentPath, $menuUrl)) {
                // Jika url menu lebih panjang dari yang sebelumnya ditemukan (lebih spesifik), pakai ini
                if (!$currentMenu || strlen($menuUrl) > strlen('/' . trim($currentMenu->url, '/'))) {
                    $currentMenu = $menu;
                }
            } else if ($menuUrl === '/' && $currentPath === '/') {
                $currentMenu = $menu;
            }
        }

        // Route di dalam middleware permission harus punya mapping menu eksplisit.
        if (!$currentMenu) {
            abort(403, 'Akses Ditolak: menu untuk route ini belum dikonfigurasi.');
        }

        // 4. Cek Permission di Database
        $permission = Cache::remember(
            "permission_role:{$user->role_id}:menu:{$currentMenu->id}:v{$cacheVersion}",
            3600,
            function () use ($user, $currentMenu) {
                return Permission::where('role_id', $user->role_id)
                    ->where('menu_id', $currentMenu->id)
                    ->first(['can_view', 'can_add', 'can_update', 'can_delete']);
            }
        );

        if (!$permission) {
            if (!$user->isSuperAdmin()) {
                abort(403, 'Anda tidak memiliki hak akses untuk menu ini.');
            }

            $permission = (object) [
                'can_view' => true,
                'can_add' => true,
                'can_update' => true,
                'can_delete' => true,
            ];
        }

        // 5. Tentukan Action & Cek Hak Akses Spesifik
        $method = $request->method(); // GET, POST, PUT, DELETE
        $routeName = $request->route()?->getName() ?? ''; // users.create, users.store, dll

        // Default View Check
        if (!$permission->can_view) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin melihat halaman ini.');
        }

        $isRestoreAction = Str::contains($routeName, ['restore']);

        // Create/Add Check
        if (($method === 'POST' && !$isRestoreAction) || Str::contains($routeName, ['create', 'store', 'upload'])) {
            if (!$permission->can_add) {
                abort(403, 'Akses Ditolak: Anda tidak memiliki izin menambah data.');
            }
        }

        // Update/Edit Check
        if ($method === 'PUT' || $method === 'PATCH' || Str::contains($routeName, ['edit', 'update', 'restore'])) {
            if (!$permission->can_update) {
                abort(403, 'Akses Ditolak: Anda tidak memiliki izin mengubah data.');
            }
        }

        // Delete Check
        if ($method === 'DELETE' || Str::contains($routeName, ['destroy', 'delete'])) {
            if (!$permission->can_delete) {
                // Untuk AJAX delete, return JSON response
                if ($request->ajax()) {
                    return response()->json(['message' => 'Akses Ditolak: Anda tidak memiliki izin menghapus data.'], 403);
                }
                abort(403, 'Akses Ditolak: Anda tidak memiliki izin menghapus data.');
            }
        }

        return $next($request);
    }

    private function pathMatchesMenu(string $currentPath, string $menuUrl): bool
    {
        return $currentPath === $menuUrl || Str::startsWith($currentPath, $menuUrl . '/');
    }
}
