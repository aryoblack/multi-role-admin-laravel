@extends('layouts.app')

@section('title', 'Manage Permission - ' . $role->nama_role)

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-shield-alt text-lg"></i>
                    </span>
                    Manage Permissions
                </h1>
                <p class="page-subtitle">Role: <span class="font-bold text-blue-600">{{ $role->nama_role }}</span></p>
            </div>
            <a href="{{ route('roles.index') }}"
                class="btn-secondary-theme">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="panel">
        <!-- Card Header -->
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-check-square"></i>
                Daftar Hak Akses Menu
            </h3>
        </div>

        <!-- Table Container -->
        <div class="p-0 sm:p-6 overflow-x-auto">
            <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                @if(!$pagePermission->can_update)
                    <div class="m-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
                        Anda hanya memiliki akses melihat permission. Perubahan hak akses tidak tersedia untuk role Anda.
                    </div>
                @endif

                <fieldset {{ !$pagePermission->can_update ? 'disabled' : '' }}>
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider" width="35%">Menu Utama</th>
                                <th class="px-3 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-eye text-blue-500 mb-1 block"></i>View
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-plus text-emerald-500 mb-1 block"></i>Add
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-edit text-amber-500 mb-1 block"></i>Update
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-trash text-red-500 mb-1 block"></i>Delete
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-check-double text-indigo-500 mb-1 block"></i>All
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($menus as $menu)
                            @php
                            $permission = $permissionsData->get($menu->id);
                            $hasChildren = $menu->children->count() > 0;
                            $rowClass = $hasChildren ? 'bg-gray-50/50' : 'hover:bg-blue-50/50';
                            @endphp
                            <tr class="{{ $rowClass }} transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($menu->icon)
                                        <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 shadow-sm flex items-center justify-center text-blue-600">
                                            <i class="{{ $menu->icon }}"></i>
                                        </div>
                                        @endif
                                        <span class="font-bold text-gray-900">{{ $menu->nama_menu }}</span>
                                    </div>
                                    <input type="hidden" name="permissions[{{ $loop->index }}][menu_id]" value="{{ $menu->id }}">
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer permission-check"
                                        name="permissions[{{ $loop->index }}][can_view]"
                                        value="1"
                                        data-row="{{ $loop->index }}"
                                        {{ $permission && $permission->can_view ? 'checked' : '' }}>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    @if(!$hasChildren)
                                    <input type="checkbox" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer permission-check"
                                        name="permissions[{{ $loop->index }}][can_add]"
                                        value="1"
                                        data-row="{{ $loop->index }}"
                                        {{ $permission && $permission->can_add ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-center">
                                    @if(!$hasChildren)
                                    <input type="checkbox" class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 cursor-pointer permission-check"
                                        name="permissions[{{ $loop->index }}][can_update]"
                                        value="1"
                                        data-row="{{ $loop->index }}"
                                        {{ $permission && $permission->can_update ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-center">
                                    @if(!$hasChildren)
                                    <input type="checkbox" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 cursor-pointer permission-check"
                                        name="permissions[{{ $loop->index }}][can_delete]"
                                        value="1"
                                        data-row="{{ $loop->index }}"
                                        {{ $permission && $permission->can_delete ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-center">
                                    @if(!$hasChildren)
                                    <input type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer check-all"
                                        data-row="{{ $loop->index }}">
                                    @else
                                    <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>

                            @if($hasChildren)
                            @foreach($menu->children as $child)
                            @php
                            $childPermission = $permissionsData->get($child->id);
                            $childIndex = $loop->parent->index . '_' . $loop->index;
                            @endphp
                            <tr class="hover:bg-blue-50/50 divide-x-0 transition-colors">
                                <td class="px-6 py-4 flex items-center gap-3 pl-12">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-level-up-alt fa-rotate-90 text-gray-300 text-sm"></i>
                                        @if($child->icon)
                                        <i class="{{ $child->icon }} text-gray-500"></i>
                                        @endif
                                    </div>
                                    <span class="text-gray-700">{{ $child->nama_menu }}</span>
                                    <input type="hidden" name="permissions[{{ $childIndex }}][menu_id]" value="{{ $child->id }}">
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer permission-check"
                                        name="permissions[{{ $childIndex }}][can_view]"
                                        value="1"
                                        data-row="{{ $childIndex }}"
                                        {{ $childPermission && $childPermission->can_view ? 'checked' : '' }}>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer permission-check"
                                        name="permissions[{{ $childIndex }}][can_add]"
                                        value="1"
                                        data-row="{{ $childIndex }}"
                                        {{ $childPermission && $childPermission->can_add ? 'checked' : '' }}>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 cursor-pointer permission-check"
                                        name="permissions[{{ $childIndex }}][can_update]"
                                        value="1"
                                        data-row="{{ $childIndex }}"
                                        {{ $childPermission && $childPermission->can_update ? 'checked' : '' }}>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 cursor-pointer permission-check"
                                        name="permissions[{{ $childIndex }}][can_delete]"
                                        value="1"
                                        data-row="{{ $childIndex }}"
                                        {{ $childPermission && $childPermission->can_delete ? 'checked' : '' }}>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <input type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer check-all"
                                        data-row="{{ $childIndex }}">
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </fieldset>

                <div class="px-6 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end">
                    @if($pagePermission->can_update)
                        <button type="submit" class="btn-primary-theme">
                            <i class="fas fa-save text-lg transition-transform group-hover:scale-110"></i>
                            <span>Simpan Hak Akses</span>
                        </button>
                    @else
                        <span class="text-sm text-gray-500">Mode lihat saja</span>
                    @endif
                </div>
            </form>
        </div>
        @endsection

        @push('scripts')
        <script>
            $(document).ready(function() {
                // Check all permissions for a row
                $('.check-all').on('change', function() {
                    const row = $(this).data('row');
                    const isChecked = $(this).is(':checked');

                    $(`.permission-check[data-row="${row}"]`).prop('checked', isChecked);
                });

                // Update check-all status when individual permission changes
                $('.permission-check').on('change', function() {
                    const row = $(this).data('row');
                    const totalChecks = $(`.permission-check[data-row="${row}"]`).length;
                    const checkedCount = $(`.permission-check[data-row="${row}"]:checked`).length;

                    $(`.check-all[data-row="${row}"]`).prop('checked', totalChecks === checkedCount);
                });

                // Initialize check-all status on page load
                $('.check-all').each(function() {
                    const row = $(this).data('row');
                    const totalChecks = $(`.permission-check[data-row="${row}"]`).length;
                    const checkedCount = $(`.permission-check[data-row="${row}"]:checked`).length;

                    $(this).prop('checked', totalChecks === checkedCount && totalChecks > 0);
                });
            });
        </script>
        @endpush
