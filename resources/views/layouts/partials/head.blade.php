<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', $appName ?? config('app.name'))</title>
@if(!empty($appSetting?->app_favicon))
<link rel="icon" href="{{ asset('storage/' . $appSetting->app_favicon) }}">
@endif

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Font Awesome (Local) -->
<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
<!-- SweetAlert2 (Local) -->
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">

<!-- Tailwind CSS -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root {
        --app-primary: {{ $appSetting->primary_color ?? '#2563eb' }};
        --app-secondary: {{ $appSetting->secondary_color ?? '#1d4ed8' }};
    }

    .bg-blue-600,
    .page-title-icon,
    .btn-primary-theme,
    .welcome-banner,
    .dataTables_paginate .paginate_button.current {
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

    .border-blue-600,
    .focus\:border-blue-500:focus {
        border-color: var(--app-primary) !important;
    }

    .focus\:ring-blue-500:focus {
        --tw-ring-color: var(--app-primary) !important;
    }
</style>

@stack('styles')
