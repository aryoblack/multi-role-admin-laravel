@extends('layouts.app')

@section('title', 'Pengaturan Perusahaan')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-building text-lg"></i>
                    </span>
                    Pengaturan Perusahaan
                </h1>
                <p class="page-subtitle">Kelola informasi identitas perusahaan Anda</p>
            </div>
        </div>
    </div>
    <!-- Table Card -->
    <div class="panel mt-2">
        <!-- Card Header -->
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-edit"></i>
                Form Pengaturan
            </h3>
        </div>

        <!-- Form Container -->
        <div class="p-6">
            @if(session('success'))
            <div class="mb-6 animate-fade-in">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="text-emerald-400 hover:text-emerald-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            <form action="{{ route('company-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                @if(!$pagePermission->can_update)
                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
                        Anda hanya memiliki akses melihat pengaturan perusahaan. Perubahan tidak tersedia untuk role Anda.
                    </div>
                @endif

                <fieldset {{ !$pagePermission->can_update ? 'disabled' : '' }}>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Left Column: Basic Info -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <input type="text"
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_name" name="company_name"
                                        value="{{ old('company_name', $setting->company_name) }}" required>
                                </div>
                                @error('company_name')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="company_address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <textarea
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_address') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_address" name="company_address" rows="3">{{ old('company_address', $setting->company_address) }}</textarea>
                                </div>
                                @error('company_address')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <input type="text"
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_phone') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_phone" name="company_phone"
                                        value="{{ old('company_phone', $setting->company_phone) }}">
                                </div>
                                @error('company_phone')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Perusahaan</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email"
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_email') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_email" name="company_email"
                                        value="{{ old('company_email', $setting->company_email) }}">
                                </div>
                                @error('company_email')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="company_website" class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <input type="url"
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_website') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_website" name="company_website"
                                        value="{{ old('company_website', $setting->company_website) }}"
                                        placeholder="https://example.com">
                                </div>
                                @error('company_website')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="company_description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Perusahaan</label>
                                <div class="relative group">
                                    <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-align-left"></i>
                                    </div>
                                    <textarea
                                        class="block w-full pl-11 pr-4 py-3 border @error('company_description') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 outline-none text-gray-900 bg-white"
                                        id="company_description" name="company_description" rows="4">{{ old('company_description', $setting->company_description) }}</textarea>
                                </div>
                                @error('company_description')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Logo Upload -->
                    <div class="lg:col-span-4">
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100 sticky top-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Logo Perusahaan</label>

                            <div class="flex flex-col items-center">
                                <div id="logo-preview-container" class="relative group mb-6">
                                    <div class="w-48 h-48 bg-white rounded-lg shadow-inner border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-300">
                                        @if($setting->company_logo)
                                        <img src="{{ asset('storage/' . $setting->company_logo) }}"
                                            alt="Company Logo"
                                            id="logo-preview"
                                            class="w-full h-full object-contain p-2">
                                        @else
                                        <div id="logo-placeholder" class="text-center p-4">
                                            <i class="fas fa-image text-4xl text-gray-300 mb-2"></i>
                                            <p class="text-xs text-gray-400">Belum ada logo</p>
                                        </div>
                                        <img id="logo-preview" class="w-full h-full object-contain p-2 hidden">
                                        @endif
                                    </div>

                                    <label for="company_logo" class="absolute -bottom-3 -right-3 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-700 transition-transform hover:scale-110 active:scale-95">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" class="hidden" id="company_logo" name="company_logo" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                </div>

                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-1">Klik ikon kamera untuk ganti logo</p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">JPG, PNG (Max. 2MB)</p>
                                </div>

                                @error('company_logo')
                                <p class="mt-4 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-100 flex items-center gap-2 w-full">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                </fieldset>

                <div class="pt-8 border-t border-gray-100 flex items-center justify-end gap-3">
                    @if($pagePermission->can_update)
                        <button type="reset" class="btn-secondary-theme">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn-primary-theme">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    @else
                        <span class="text-sm text-gray-500">Mode lihat saja</span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('company_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logo-preview');
                const placeholder = document.getElementById('logo-placeholder');

                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
