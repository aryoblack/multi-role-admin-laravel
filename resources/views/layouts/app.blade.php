<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    @include('layouts.partials.head')
    @include('layouts.partials.styles')
</head>

<body class="h-full overflow-hidden">
    <div id="wrapper" class="flex h-screen overflow-hidden">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity duration-300" id="sidebar-overlay"></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Page Content -->
        <div id="page-content-wrapper" class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
            <!-- Header -->
            @include('layouts.partials.header')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="container-fluid px-4 sm:px-6 lg:px-8 pt-3 pb-8 lg:pt-4 lg:pb-10">
                    @include('layouts.partials.alerts')
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>

</html>
