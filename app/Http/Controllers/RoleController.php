<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Support\PermissionResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $pagePermission = PermissionResolver::forPath(request()->user(), '/roles');
        $query = Role::withCount('users')->orderBy('created_at', 'desc');

        if (!auth()->user()->isSuperAdmin()) {
            $query->where('nama_role', '!=', User::SUPER_ADMIN_ROLE);
        }

        $roles = $query->get();
        return view('roles.index', compact('roles', 'pagePermission'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create($request->validated());
        $this->refreshPermissionCache();

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(Role $role)
    {
        if (!auth()->user()->isSuperAdmin() && $role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Akses ditolak!');
        }

        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        if (!auth()->user()->isSuperAdmin() && $role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Akses ditolak!');
        }

        if ($role->nama_role === User::SUPER_ADMIN_ROLE && $request->validated()['nama_role'] !== User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Role Super Admin tidak boleh diubah namanya');
        }

        $role->update($request->validated());
        $this->refreshPermissionCache();

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        if (!auth()->user()->isSuperAdmin() && $role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Akses ditolak!');
        }

        if ($role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Role Super Admin tidak boleh dihapus');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user');
        }

        $role->delete();
        $this->refreshPermissionCache();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }

    public function permissions(Role $role)
    {
        $pagePermission = PermissionResolver::forPath(request()->user(), '/roles');

        if (!auth()->user()->isSuperAdmin() && $role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Akses ditolak!');
        }

        $menus = Menu::with(['children' => function ($query) {
            $query->orderBy('urutan');
        }])->whereNull('parent_id')->orderBy('urutan')->get();

        // Get existing permissions for this role
        $existingPermissions = $role->permissions()->pluck('menu_id')->toArray();
        $permissionsData = $role->permissions()->get()->keyBy('menu_id');

        return view('roles.permissions', compact('role', 'menus', 'existingPermissions', 'permissionsData', 'pagePermission'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        if (!auth()->user()->isSuperAdmin() && $role->nama_role === User::SUPER_ADMIN_ROLE) {
            return redirect()->route('roles.index')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*.menu_id' => 'required|exists:menus,id',
            'permissions.*.can_view' => 'boolean',
            'permissions.*.can_add' => 'boolean',
            'permissions.*.can_update' => 'boolean',
            'permissions.*.can_delete' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $role) {
            // Delete existing permissions for this role
            $role->permissions()->delete();

            // Create new permissions
            foreach ($request->permissions as $permission) {
                // Only create if at least one permission is granted
                if (
                    !empty($permission['can_view']) || !empty($permission['can_add']) ||
                    !empty($permission['can_update']) || !empty($permission['can_delete'])
                ) {

                    $role->permissions()->create([
                        'menu_id' => $permission['menu_id'],
                        'can_view' => !empty($permission['can_view']),
                        'can_add' => !empty($permission['can_add']),
                        'can_update' => !empty($permission['can_update']),
                        'can_delete' => !empty($permission['can_delete']),
                    ]);
                }
            }
        });

        $this->refreshPermissionCache();

        return redirect()->route('roles.permissions', $role->id)
            ->with('success', 'Permission berhasil diperbarui');
    }

    private function refreshPermissionCache(): void
    {
        Cache::forever('permission_cache_version', ((int) Cache::get('permission_cache_version', 1)) + 1);
    }
}
