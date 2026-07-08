@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-shell">
    <div class="panel">
        <div class="panel-body p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center lg:gap-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white sm:h-16 sm:w-16 lg:h-20 lg:w-20">
                    <i class="fas fa-home text-2xl sm:text-3xl lg:text-4xl"></i>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl font-bold leading-tight text-gray-900 sm:text-2xl lg:text-3xl">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 lg:text-base">
                        Anda login sebagai <span class="font-semibold">{{ Auth::user()->role_name }}</span>
                        <span class="mx-2 hidden sm:inline">/</span>
                        <span class="block sm:inline">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="stat-card">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="stat-icon bg-blue-50 text-blue-600">
                    <i class="fas fa-users text-xl sm:text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ \App\Models\User::where('status', 'active')->count() }} Active</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="stat-icon bg-emerald-50 text-emerald-600">
                    <i class="fas fa-user-shield text-xl sm:text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-600">Total Roles</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ \App\Models\Role::count() }}</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-gray-500">
                        <i class="fas fa-layer-group"></i>
                        <span>Role Groups</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="stat-icon bg-amber-50 text-amber-600">
                    <i class="fas fa-bars text-xl sm:text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-600">Total Menus</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ \App\Models\Menu::count() }}</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-gray-500">
                        <i class="fas fa-sitemap"></i>
                        <span>Menu Items</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="stat-icon bg-purple-50 text-purple-600">
                    <i class="fas fa-key text-xl sm:text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-600">Permissions</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ \App\Models\Permission::count() }}</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-gray-500">
                        <i class="fas fa-lock"></i>
                        <span>Access Rules</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-bolt text-blue-600"></i>
                    Quick Actions
                </h2>
            </div>
            <div class="panel-body">
                <div class="space-y-2">
                    <a href="{{ route('users.index') }}" class="action-card">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 sm:h-11 sm:w-11">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-gray-900">Manage Users</div>
                            <p class="text-sm text-gray-500">View and manage user accounts</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('roles.index') }}" class="action-card">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-gray-900">Manage Roles</div>
                            <p class="text-sm text-gray-500">Configure roles and permissions</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('menus.index') }}" class="action-card">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 sm:h-11 sm:w-11">
                            <i class="fas fa-bars"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-gray-900">Manage Menus</div>
                            <p class="text-sm text-gray-500">Configure navigation menus</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('company-settings.index') }}" class="action-card">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600 sm:h-11 sm:w-11">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-gray-900">Company Settings</div>
                            <p class="text-sm text-gray-500">Update company information</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    System Information
                </h2>
            </div>
            <div class="panel-body">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                        <p class="mb-1 flex items-center gap-2 text-sm text-emerald-700">
                            <i class="fas fa-user-check"></i>
                            Active Users
                        </p>
                        <p class="text-2xl font-bold text-emerald-800">{{ \App\Models\User::where('status', 'active')->count() }}</p>
                    </div>
                    <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                        <p class="mb-1 flex items-center gap-2 text-sm text-red-700">
                            <i class="fas fa-user-times"></i>
                            Inactive Users
                        </p>
                        <p class="text-2xl font-bold text-red-800">{{ \App\Models\User::where('status', 'inactive')->count() }}</p>
                    </div>
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <p class="mb-1 flex items-center gap-2 text-sm text-blue-700">
                            <i class="fas fa-clock"></i>
                            Last Login
                        </p>
                        <p class="text-sm font-semibold text-blue-800">{{ Auth::user()->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <p class="mb-1 flex items-center gap-2 text-sm text-gray-700">
                            <i class="fas fa-code-branch"></i>
                            Version
                        </p>
                        <p class="text-sm font-semibold text-gray-900">v1.0.0</p>
                    </div>
                </div>

                @if($companySetting)
                <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <div class="flex items-center gap-4">
                        @if($companySetting->company_logo)
                        <img src="{{ asset('storage/' . $companySetting->company_logo) }}" alt="Logo" class="h-14 w-14 rounded-lg bg-white object-contain p-2 shadow-sm">
                        @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="truncate font-bold text-gray-900">{{ $companySetting->company_name }}</div>
                            <p class="truncate text-sm text-gray-600">{{ $companySetting->company_email }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
