@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-user-circle text-lg"></i>
                    </span>
                    Pengaturan Profil
                </h1>
                <p class="page-subtitle">Kelola informasi pribadi dan keamanan akun Anda</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 animate-fade-in">
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" class="text-emerald-400 hover:text-emerald-600" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Profile Info -->
        <div class="lg:col-span-4 space-y-6">
            <div class="panel text-center p-8">
                <div class="relative inline-block mb-6">
                    <div class="w-32 h-32 bg-blue-600 rounded-lg flex items-center justify-center text-white text-5xl font-bold shadow-md ring-4 ring-white">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 border-4 border-white rounded-full" title="Status: {{ ucfirst($user->status) }}"></div>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                <p class="text-sm font-medium text-blue-600 mb-4">{{ $user->role->nama_role }}</p>

                <div class="flex flex-col gap-2 text-sm text-gray-500 border-t border-gray-50 pt-6">
                    <div class="flex items-center justify-center gap-2">
                        <i class="fas fa-envelope text-gray-400"></i>
                        {{ $user->email }}
                    </div>
                    @if($user->phone)
                    <div class="flex items-center justify-center gap-2">
                        <i class="fas fa-phone text-gray-400"></i>
                        {{ $user->phone }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats/Info Card -->
            <div class="bg-blue-600 rounded-lg shadow-sm p-6 text-white text-center">
                <p class="text-blue-100 text-sm mb-2">Member Sejak</p>
                <p class="text-xl font-bold">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Right: Edit Form -->
        <div class="lg:col-span-8">
            <div class="panel">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-edit text-blue-500"></i>
                        Update Informasi
                    </h3>
                </div>

                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" required>
                                </div>
                                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-1">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" required>
                                </div>
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-1">
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                </div>
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2 pt-4 border-t border-gray-50 mt-2">
                                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Ubah Password (Kosongkan jika tidak ingin mengubah)</h4>
                            </div>

                            <!-- Current Password -->
                            <div class="md:col-span-2">
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-lock text-xs"></i>
                                    </div>
                                    <input type="password" name="current_password" id="current_password"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                                        placeholder="Konfirmasi password lama">
                                </div>
                                @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-key text-xs"></i>
                                    </div>
                                    <input type="password" name="new_password" id="new_password"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                                        placeholder="Password baru">
                                </div>
                                @error('new_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- New Password Confirmation -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-check-double text-xs"></i>
                                    </div>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex justify-end">
                            <button type="submit" class="btn-primary-theme">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection