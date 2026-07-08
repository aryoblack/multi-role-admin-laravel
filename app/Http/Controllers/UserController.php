<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $users = User::with('role')->select('users.*');

            if (!auth()->user()->isSuperAdmin()) {
                $users->whereHas('role', function ($q) {
                    $q->where('nama_role', '!=', User::SUPER_ADMIN_ROLE);
                });
            }

            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('role_name', function ($user) {
                    return $user->role->nama_role ?? '-';
                })
                ->addColumn('status_badge', function ($user) {
                    return $user->status === 'active'
                        ? '<span class="badge-modern bg-green-100 text-green-700 border border-green-200">Active</span>'
                        : '<span class="badge-modern bg-red-100 text-red-700 border border-red-200">Inactive</span>';
                })
                ->addColumn('action', function ($user) {
                    $editBtn = '<button type="button" class="icon-action icon-action-edit edit-btn" data-id="' . $user->id . '" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>';
                    $deleteBtn = '<button type="button" class="icon-action icon-action-delete delete-btn" data-id="' . $user->id . '" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>';
                    return '<div class="flex items-center justify-center gap-2">' . $editBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $roles = Role::query();
        if (!auth()->user()->isSuperAdmin()) {
            $roles->where('nama_role', '!=', User::SUPER_ADMIN_ROLE);
        }
        $roles = $roles->get();

        return view('users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::query();
        if (!auth()->user()->isSuperAdmin()) {
            $roles->where('nama_role', '!=', User::SUPER_ADMIN_ROLE);
        }
        $roles = $roles->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $this->userService->createUser($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan user. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        if (!auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!'], 403);
        }

        $user->load('role');
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): JsonResponse
    {
        if (!auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!'], 403);
        }

        $user->load('role');

        $roles = Role::query();
        if (!auth()->user()->isSuperAdmin()) {
            $roles->where('nama_role', '!=', User::SUPER_ADMIN_ROLE);
        }

        return response()->json([
            'user' => $user,
            'roles' => $roles->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if (!auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!'], 403);
        }

        try {
            $this->userService->updateUser($user, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui user. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if (!auth()->user()->isSuperAdmin() && $user->isSuperAdmin()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!'], 403);
        }

        try {
            $this->userService->deleteUser($user);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus user. Silakan coba lagi.'
            ], 500);
        }
    }
}
