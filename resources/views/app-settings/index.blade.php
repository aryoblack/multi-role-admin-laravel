@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-cog text-lg"></i>
                    </span>
                    Pengaturan Aplikasi
                </h1>
                <p class="page-subtitle">Konfigurasi sistem dan branding aplikasi</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-sliders-h"></i>
                Konfigurasi Umum
            </h3>
        </div>

        <div class="p-6">
            <form action="{{ route('app-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Basic Branding -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="app_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Aplikasi</label>
                                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $setting->app_name) }}"
                                    class="form-field">
                            </div>

                            <div class="md:col-span-2">
                                <label for="footer_text" class="block text-sm font-semibold text-gray-700 mb-2">Teks Footer</label>
                                <input type="text" id="footer_text" name="footer_text" value="{{ old('footer_text', $setting->footer_text) }}"
                                    class="form-field">
                            </div>

                            <div>
                                <label for="primary_color" class="block text-sm font-semibold text-gray-700 mb-2">Warna Utama (Primary)</label>
                                <div class="flex gap-2">
                                    <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $setting->primary_color) }}"
                                        class="h-12 w-20 border border-gray-200 rounded-lg cursor-pointer p-1">
                                    <input type="text" id="primary_color_text" value="{{ old('primary_color', $setting->primary_color) }}" readonly
                                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="secondary_color" class="block text-sm font-semibold text-gray-700 mb-2">Warna Sekunder (Secondary)</label>
                                <div class="flex gap-2">
                                    <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $setting->secondary_color) }}"
                                        class="h-12 w-20 border border-gray-200 rounded-lg cursor-pointer p-1">
                                    <input type="text" id="secondary_color_text" value="{{ old('secondary_color', $setting->secondary_color) }}" readonly
                                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <div class="flex items-center justify-between p-4 bg-red-50/50 rounded-lg border border-red-100">
                                <div>
                                    <h4 class="font-bold text-red-800 text-sm">Mode Perawatan</h4>
                                    <p class="text-xs text-red-500/70">Matikan akses publik ke sistem</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" {{ $setting->maintenance_mode ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Assets Upload -->
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Logo Utama</label>
                            <div class="flex flex-col items-center">
                                <div class="w-full aspect-video bg-white rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden mb-4 relative group">
                                    @if($setting->app_logo)
                                    <img src="{{ asset('storage/' . $setting->app_logo) }}" class="max-w-[80%] max-h-[80%] object-contain" id="logo-preview">
                                    @else
                                    <i class="fas fa-image text-3xl text-gray-300" id="logo-icon"></i>
                                    <img class="max-w-[80%] max-h-[80%] object-contain hidden" id="logo-preview">
                                    @endif
                                    <label class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white text-sm font-bold">
                                        Ganti Logo
                                        <input type="file" name="app_logo" class="hidden" accept="image/*" onchange="previewImg(this, 'logo-preview', 'logo-icon')">
                                    </label>
                                </div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">PNG/JPG (Max 2MB)</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Favicon</label>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-white rounded-xl border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0 relative group">
                                    @if($setting->app_favicon)
                                    <img src="{{ asset('storage/' . $setting->app_favicon) }}" class="w-8 h-8 object-contain" id="favicon-preview">
                                    @else
                                    <i class="fas fa-gem text-xl text-gray-300" id="favicon-icon"></i>
                                    <img class="max-w-full max-h-full object-contain hidden" id="favicon-preview">
                                    @endif
                                    <label class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
                                        <i class="fas fa-plus text-xs"></i>
                                        <input type="file" name="app_favicon" class="hidden" accept="image/x-icon,image/png" onchange="previewImg(this, 'favicon-preview', 'favicon-icon')">
                                    </label>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-gray-800 mb-1">Ikon Browser</h5>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">ICO/PNG (32x32px)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-100 flex items-center justify-end gap-3">
                    <button type="submit" class="btn-primary-theme">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImg(input, previewId, iconId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const icon = document.getElementById(iconId);
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (icon) {
                    icon.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const colorPairs = [
            ['primary_color', 'primary_color_text'],
            ['secondary_color', 'secondary_color_text'],
        ];

        colorPairs.forEach(function(pair) {
            const picker = document.getElementById(pair[0]);
            const text = document.getElementById(pair[1]);

            if (!picker || !text) {
                return;
            }

            text.value = picker.value;
            picker.addEventListener('input', function() {
                text.value = picker.value;
            });
        });
    });
</script>
@endpush
