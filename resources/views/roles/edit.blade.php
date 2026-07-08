@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-edit text-lg"></i>
                    </span>
                    Edit Role
                </h1>
                <p class="page-subtitle">Perbarui data role sistem</p>
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
                <i class="fas fa-edit"></i>
                Form Edit Role
            </h3>
        </div>

        <!-- Form Container -->
        <div class="p-6">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="max-w-2xl">
                    <label for="nama_role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-edit"></i>
                        </div>
                        <input type="text"
                            class="block w-full pl-11 pr-4 py-3 border @error('nama_role') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white shadow-sm"
                            id="nama_role" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}"
                            placeholder="Contoh: Admin, Manager, Staff" required>
                    </div>
                    @error('nama_role')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 italic">Nama role harus unik dan mewakili tanggung jawab pengguna.</p>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('roles.index') }}"
                        class="btn-secondary-theme">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-primary-theme">
                        <i class="fas fa-save"></i>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection