<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Support\PermissionResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    private function normalizeIcon(?string $icon): string
    {
        $icon = trim((string) $icon);

        if ($icon === '') {
            return 'fas fa-bars';
        }

        if (preg_match('/\b(fas|far|fab|fal|fad|fa-solid|fa-regular|fa-brands)\b/', $icon)) {
            return $icon;
        }

        return 'fas ' . $icon;
    }

    public function index(Request $request): View|JsonResponse
    {
        $pagePermission = PermissionResolver::forPath($request->user(), '/menus');

        if ($request->ajax()) {
            $menus = Menu::with('parent')->select('menus.*');

            return DataTables::eloquent($menus)
                ->addIndexColumn()
                ->addColumn('parent_name', function ($menu) {
                    return $menu->parent ? $menu->parent->nama_menu : '-';
                })
                ->addColumn('icon_display', function ($menu) {
                    $icon = e($this->normalizeIcon($menu->icon));
                    $label = e($menu->icon ?: 'fas fa-bars');

                    return '<span class="inline-flex items-center gap-2 rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-700">'
                        . '<span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">'
                        . '<i class="' . $icon . '"></i>'
                        . '</span>'
                        . '<code class="text-xs text-gray-500">' . $label . '</code>'
                        . '</span>';
                })
                ->addColumn('icon_html', function ($menu) {
                    $icon = e($this->normalizeIcon($menu->icon));

                    return '<i class="' . $icon . '"></i>';
                })
                ->addColumn('url_display', function ($menu) {
                    return '<code>' . $menu->url . '</code>';
                })
                ->addColumn('action', function ($menu) use ($pagePermission) {
                    $buttons = '';

                    if ($pagePermission->can_update) {
                        $buttons .= '<button type="button" class="icon-action icon-action-edit edit-btn" data-id="' . $menu->id . '" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>';
                    }

                    if ($pagePermission->can_delete) {
                        $buttons .= '<button type="button" class="icon-action icon-action-delete delete-btn" data-id="' . $menu->id . '" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>';
                    }

                    return $buttons !== ''
                        ? '<div class="flex items-center justify-center gap-2">' . $buttons . '</div>'
                        : '<span class="text-gray-400">-</span>';
                })
                ->rawColumns(['icon_display', 'icon_html', 'url_display', 'action'])
                ->make(true);
        }

        $parentMenus = Menu::whereNull('parent_id')->orderBy('urutan')->get();
        return view('menus.index', compact('parentMenus', 'pagePermission'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('urutan')->get();
        return view('menus.create', compact('parentMenus'));
    }

    public function store(StoreMenuRequest $request): JsonResponse
    {
        try {
            Menu::create($request->validated());
            $this->refreshPermissionCache();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan menu.'
            ], 500);
        }
    }

    public function edit(Menu $menu): JsonResponse
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('urutan')->get();

        return response()->json([
            'menu' => $menu,
            'parentMenus' => $parentMenus
        ]);
    }

    public function update(UpdateMenuRequest $request, Menu $menu): JsonResponse
    {
        try {
            $menu->update($request->validated());
            $this->refreshPermissionCache();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui menu.'
            ], 500);
        }
    }

    public function destroy(Menu $menu): JsonResponse
    {
        try {
            if ($menu->children()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak dapat dihapus karena masih memiliki submenu.'
                ], 422);
            }

            if ($menu->permissions()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak dapat dihapus karena masih digunakan pada permission role.'
                ], 422);
            }

            $menu->delete();
            $this->refreshPermissionCache();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus menu.'
            ], 500);
        }
    }

    private function refreshPermissionCache(): void
    {
        Cache::forever('permission_cache_version', ((int) Cache::get('permission_cache_version', 1)) + 1);
    }
}
