<?php

namespace App\Support;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PermissionResolver
{
    public static function forPath(?User $user, string $path): object
    {
        $default = (object) [
            'can_view' => false,
            'can_add' => false,
            'can_update' => false,
            'can_delete' => false,
        ];

        if (!$user || !$user->role_id) {
            return $default;
        }

        $cacheVersion = (int) Cache::get('permission_cache_version', 1);
        $currentPath = '/' . trim($path, '/');
        $menu = self::resolveMenuForPath($currentPath, $cacheVersion);

        if (!$menu) {
            return $default;
        }

        return Cache::remember(
            "permission_role:{$user->role_id}:menu:{$menu->id}:v{$cacheVersion}",
            3600,
            function () use ($user, $menu, $default) {
                return Permission::where('role_id', $user->role_id)
                    ->where('menu_id', $menu->id)
                    ->first(['can_view', 'can_add', 'can_update', 'can_delete'])
                    ?? self::fallbackPermission($user, $default);
            }
        );
    }

    private static function fallbackPermission(User $user, object $default): object
    {
        if (!$user->isSuperAdmin()) {
            return $default;
        }

        return (object) [
            'can_view' => true,
            'can_add' => true,
            'can_update' => true,
            'can_delete' => true,
        ];
    }

    private static function resolveMenuForPath(string $currentPath, int $cacheVersion): ?object
    {
        $menus = Cache::remember("permission_menus:v{$cacheVersion}", 3600, function () {
            return Menu::whereNotNull('url')
                ->where('url', '!=', '#')
                ->get(['id', 'url']);
        });

        $currentMenu = null;

        foreach ($menus as $menu) {
            $menuUrl = '/' . trim($menu->url, '/');

            if ($menuUrl !== '/' && self::pathMatchesMenu($currentPath, $menuUrl)) {
                if (!$currentMenu || strlen($menuUrl) > strlen('/' . trim($currentMenu->url, '/'))) {
                    $currentMenu = $menu;
                }
            } elseif ($menuUrl === '/' && $currentPath === '/') {
                $currentMenu = $menu;
            }
        }

        return $currentMenu;
    }

    private static function pathMatchesMenu(string $currentPath, string $menuUrl): bool
    {
        return $currentPath === $menuUrl || Str::startsWith($currentPath, $menuUrl . '/');
    }
}
