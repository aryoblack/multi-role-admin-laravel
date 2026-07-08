@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <span class="page-title-icon">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Menu
            </h1>
            <p class="page-subtitle">Perbarui item navigasi sistem</p>
        </div>
        <a href="{{ route('menus.index') }}" class="btn-secondary-theme">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-bars"></i>
                Form Edit Menu
            </h3>
        </div>
        <div class="panel-body">
            <form action="{{ route('menus.update', $menu->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="nama_menu" class="form-label">Nama Menu <span class="text-red-500">*</span></label>
                        <input type="text" class="form-field @error('nama_menu') border-red-500 @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                        @error('nama_menu')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="url" class="form-label">URL <span class="text-red-500">*</span></label>
                        <input type="text" class="form-field @error('url') border-red-500 @enderror" id="url" name="url" value="{{ old('url', $menu->url) }}" required>
                        @error('url')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon" class="form-label">Icon (Font Awesome)</label>
                        <input type="text" class="form-field @error('icon') border-red-500 @enderror" id="icon" name="icon" value="{{ old('icon', $menu->icon) }}" placeholder="fas fa-home">
                        <p class="mt-2 text-xs text-gray-500">Contoh: fas fa-home, fas fa-users</p>
                        @error('icon')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select class="form-field @error('parent_id') border-red-500 @enderror" id="parent_id" name="parent_id">
                            <option value="">-- Tidak Ada Parent (Menu Utama) --</option>
                            @foreach($parentMenus as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->nama_menu }}
                            </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urutan" class="form-label">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" class="form-field @error('urutan') border-red-500 @enderror" id="urutan" name="urutan" value="{{ old('urutan', $menu->urutan) }}" min="0" required>
                        @error('urutan')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('menus.index') }}" class="btn-secondary-theme">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-primary-theme">
                        <i class="fas fa-save"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
