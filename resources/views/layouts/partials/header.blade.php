<!-- Top Navigation -->
<nav class="sticky top-0 bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm" style="z-index: 1040;">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-14 lg:h-16">
        <!-- Left Section -->
        <div class="flex items-center gap-3 lg:gap-4">
            <button class="p-2 lg:p-2.5 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                id="menu-toggle"
                aria-label="Toggle Menu">
                <i class="fas fa-bars text-lg lg:text-xl"></i>
            </button>
            <h5 class="hidden md:block text-lg lg:text-xl font-bold text-gray-900">
                @yield('header_title', '')
            </h5>
        </div>

        <!-- Right Section - User Menu -->
        <div class="relative group">
            <button class="flex items-center gap-2 lg:gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                id="userDropdown"
                aria-expanded="false">
                <!-- User Info (Hidden on mobile) -->
                <div class="hidden md:flex flex-col items-end">
                    <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</div>
                    <small class="text-xs text-gray-500">{{ Auth::user()->role_name ?? 'User' }}</small>
                </div>

                <!-- Avatar -->
                <div class="w-10 h-10 lg:w-11 lg:h-11 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-sm lg:text-base shadow-sm ring-2 ring-white text-uppercase">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>

                <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block transition-transform duration-200 group-hover:rotate-180"></i>
            </button>

            <!-- Dropdown Menu -->
            <ul class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-2 hidden z-[1100]"
                id="userDropdownMenu">
                <!-- Mobile User Info -->
                <li class="md:hidden px-4 py-3 border-b border-gray-100">
                    <div class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</div>
                    <small class="text-xs text-gray-500">{{ Auth::user()->role_name ?? 'User' }}</small>
                </li>

                <!-- Profile Link -->
                <li>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fas fa-user-circle w-5"></i>
                        <span class="font-medium">Profile</span>
                    </a>
                </li>

                <!-- Settings Link -->
                <li>
                    <a href="{{ route('company-settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fas fa-cog w-5"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </li>

                <li class="my-1 border-t border-gray-100"></li>

                <!-- Logout -->
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors duration-150 font-semibold">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownBtn = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                // Toggle visibility
                dropdownMenu.classList.toggle('hidden');

                // Toggle rotation of chevron if present
                const chevron = dropdownBtn.querySelector('.fa-chevron-down');
                if (chevron) {
                    chevron.classList.toggle('rotate-180');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                    const chevron = dropdownBtn.querySelector('.fa-chevron-down');
                    if (chevron) {
                        chevron.classList.remove('rotate-180');
                    }
                }
            });
        }
    });
</script>
