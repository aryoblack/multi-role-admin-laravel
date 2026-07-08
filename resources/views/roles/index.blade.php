@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-user-tag text-lg"></i>
                    </span>
                    Manajemen Role
                </h1>
                <p class="page-subtitle">Kelola role dan hak akses pengguna</p>
            </div>
            <a href="{{ route('roles.create') }}"
                class="btn-primary-theme">
                <i class="fas fa-plus"></i>
                <span>Tambah Role</span>
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="panel">
        <!-- Card Header -->
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">Daftar Role</span>
                <span class="sm:hidden">Roles</span>
            </h3>
        </div>

        <!-- Table Container -->
        <div class="p-3 sm:p-6">
            <!-- Mobile Card View -->
            <div class="block md:hidden space-y-3">
                @forelse($roles as $index => $role)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-200 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 truncate">{{ $role->nama_role }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        <i class="fas fa-users text-[10px]"></i>
                                        {{ $role->users_count }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $role->created_at ? $role->created_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('roles.permissions', $role->id) }}"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-shield-alt"></i>
                            <span>Permission</span>
                        </a>
                        <a href="{{ route('roles.edit', $role->id) }}"
                            class="icon-action icon-action-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('roles.destroy', $role->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="icon-action icon-action-delete disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $role->users_count > 0 ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-inbox text-3xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Tidak ada data role</p>
                        <a href="{{ route('roles.create') }}"
                            class="btn-primary-theme">
                            <i class="fas fa-plus"></i>
                            Tambah Role Pertama
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50" width="5%">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Nama Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Jumlah User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Dibuat</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $index => $role)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $role->nama_role }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-users"></i>
                                    {{ $role->users_count }} user
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                    {{ $role->created_at ? $role->created_at->translatedFormat('d M Y') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('roles.permissions', $role->id) }}"
                                        class="icon-action icon-action-info"
                                        title="Manage Permission">
                                        <i class="fas fa-shield-alt text-sm"></i>
                                    </a>
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                        class="icon-action icon-action-edit"
                                        title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="icon-action icon-action-delete disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                                            {{ $role->users_count > 0 ? 'disabled' : '' }}
                                            title="{{ $role->users_count > 0 ? 'Tidak dapat dihapus, masih ada user' : 'Hapus' }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data role</p>
                                    <a href="{{ route('roles.create') }}"
                                        class="btn-primary-theme">
                                        <i class="fas fa-plus"></i>
                                        Tambah Role Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
