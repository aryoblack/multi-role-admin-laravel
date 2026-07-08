<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $appName ?? config('app.name') }}</title>
    @if(!empty($appSetting?->app_favicon))
    <link rel="icon" href="{{ asset('storage/' . $appSetting->app_favicon) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --app-primary: {{ $appSetting->primary_color ?? '#2563eb' }};
            --app-secondary: {{ $appSetting->secondary_color ?? '#1d4ed8' }};
        }

        .bg-blue-600,
        .btn-primary-theme {
            background-color: var(--app-primary) !important;
        }

        .hover\:bg-blue-700:hover,
        .btn-primary-theme:hover {
            background-color: var(--app-secondary) !important;
        }

        .text-blue-600,
        .hover\:text-blue-600:hover {
            color: var(--app-primary) !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-color: var(--app-primary) !important;
        }
    </style>
</head>

<body class="min-h-full bg-gray-50 text-gray-900 antialiased">
    <main class="min-h-screen lg:grid lg:grid-cols-[minmax(360px,0.92fr)_minmax(420px,1.08fr)]">
        <section class="relative overflow-hidden bg-slate-950 text-white">
            <div class="absolute inset-x-0 top-0 h-px bg-white/10"></div>
            <div class="mx-auto flex min-h-[320px] max-w-3xl flex-col justify-between gap-10 px-5 py-8 sm:px-8 lg:min-h-screen lg:px-12 lg:py-12 xl:px-16">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        @if($appSetting && $appSetting->app_logo)
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white p-2 shadow-sm sm:h-14 sm:w-14">
                            <img src="{{ asset('storage/' . $appSetting->app_logo) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                        </div>
                        @else
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600 shadow-sm sm:h-14 sm:w-14">
                            <i class="fas fa-shield-alt text-xl sm:text-2xl"></i>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $appName ?? config('app.name') }}</p>
                            <p class="text-xs text-slate-400">Access Control</p>
                        </div>
                    </div>
                    <span class="hidden rounded-full border border-white/10 px-3 py-1 text-xs font-semibold text-slate-300 sm:inline-flex">
                        v1.0
                    </span>
                </div>

                <div class="max-w-xl">
                    <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-200">
                        <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                        Sistem multi-role aktif
                    </div>
                    <h1 class="text-3xl font-bold leading-tight tracking-normal sm:text-4xl lg:text-5xl">
                        Kontrol akses pengguna dalam satu tempat.
                    </h1>
                    <p class="mt-5 max-w-lg text-sm leading-6 text-slate-300 sm:text-base">
                        {{ $companySetting && $companySetting->company_description
                            ? $companySetting->company_description
                            : 'Kelola pengguna, role, menu, dan hak akses dengan struktur yang jelas untuk operasional tim.' }}
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-4">
                        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="text-sm font-semibold text-white">User</p>
                        <p class="mt-1 text-xs leading-5 text-slate-400">Kelola akun dan status pengguna.</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-4">
                        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <p class="text-sm font-semibold text-white">Role</p>
                        <p class="mt-1 text-xs leading-5 text-slate-400">Atur level akses per peran.</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-4">
                        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white">
                            <i class="fas fa-bars"></i>
                        </div>
                        <p class="text-sm font-semibold text-white">Menu</p>
                        <p class="mt-1 text-xs leading-5 text-slate-400">Sesuaikan navigasi aplikasi.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="flex min-h-[calc(100vh-320px)] items-center justify-center px-5 py-8 sm:px-8 lg:min-h-screen lg:px-10">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <p class="mb-3 text-sm font-semibold text-blue-600">Login</p>
                    <h2 class="text-2xl font-bold text-gray-950 sm:text-3xl">Masuk ke Sistem</h2>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Gunakan akun yang sudah terdaftar untuk mengakses dashboard dan modul manajemen akses.</p>
                </div>

                @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4">
                    <i class="fas fa-exclamation-circle mt-0.5 text-red-500"></i>
                    <div>
                        <p class="text-sm font-semibold text-red-800">Login gagal</p>
                        <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="form-label">Email Address</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-field h-12 pl-11" placeholder="name@company.com" autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" class="form-field h-12 pl-11 pr-12" placeholder="Masukkan password Anda" autocomplete="current-password" required>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 transition-colors hover:text-blue-600" aria-label="Tampilkan password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <label class="inline-flex cursor-pointer items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn-primary-theme h-12 w-full justify-center">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="mt-8 rounded-lg border border-gray-200 bg-white p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Akses awal</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">Gunakan akun super admin dari seeder, lalu ganti password setelah login pertama.</p>
                        </div>
                    </div>
                </div>

                <p class="mt-8 text-center text-xs text-gray-500">
                    {{ $appSetting->footer_text ?: '© ' . date('Y') . ' ' . ($appName ?? config('app.name')) . '. v1.0' }}
                </p>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (!toggleButton || !passwordInput) {
                return;
            }

            toggleButton.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleButton.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
                toggleButton.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
            });
        });
    </script>
</body>

</html>
