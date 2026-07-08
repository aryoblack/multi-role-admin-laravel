<div id="sidebar-wrapper" class="h-screen w-64 bg-slate-900 shadow-xl transition-transform duration-300 ease-in-out">

    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-white/10"></div>
    </div>

    <!-- Close Button (Mobile Only) -->
    <button id="sidebar-close"
        class="lg:hidden absolute right-3 top-3 w-9 h-9 bg-red-600 text-white rounded-lg flex items-center justify-center hover:bg-red-700 transition-colors duration-200 z-50 shadow-sm">
        <i class="fas fa-times text-sm"></i>
    </button>

    <!-- Logo Header -->
    <div class="sidebar-brand p-4 border-b border-white/10 relative z-10">
        <a href="{{ url(\App\Models\Menu::getLandingPage(Auth::user())) }}" title="{{ $appName ?? config('app.name') }}" class="sidebar-brand-link flex items-center gap-3 bg-white/5 p-3 rounded-lg border border-white/10 hover:bg-white/10 transition-all duration-200 group">
            @if($appSetting && $appSetting->app_logo)
            <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                <img src="{{ asset('storage/' . $appSetting->app_logo) }}"
                    alt="Logo"
                    class="w-full h-full object-contain p-1">
            </div>
            @else
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white text-lg shadow-sm flex-shrink-0 group-hover:scale-105 transition-transform">
                <i class="fas fa-building"></i>
            </div>
            @endif
            <div class="sidebar-brand-text flex-1 min-w-0">
                <h1 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">
                    {{ Str::limit($appName ?? config('app.name'), 18) }}
                </h1>
                <span class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Management System</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-3 space-y-1 relative z-10">
        @if(isset($sidebarMenus) && count($sidebarMenus) > 0)
        @foreach($sidebarMenus as $menu)
        @php
        $hasChildren = $menu->children->count() > 0;
        $isActive = false;

        if ($hasChildren) {
        foreach($menu->children as $child) {
        if (Request::is(ltrim($child->url, '/') . '*')) {
        $isActive = true;
        break;
        }
        if ($child->children && $child->children->count() > 0) {
        foreach($child->children as $grandchild) {
        if (Request::is(ltrim($grandchild->url, '/') . '*')) {
        $isActive = true;
        break 2;
        }
        }
        }
        }
        } else {
        $isActive = Request::is(ltrim($menu->url, '/') . '*');
        }
        @endphp

        <div class="mb-1">
            @if($hasChildren)
            <!-- Parent Menu -->
            <a href="#submenu-{{ $menu->id }}"
                data-toggle="submenu"
                aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                title="{{ $menu->nama_menu }}"
                class="menu-item-parent flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 group {{ $isActive ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <span class="menu-icon w-5 flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="{{ $menu->icon ?? 'fas fa-folder' }}"></i>
                </span>
                <span class="sidebar-menu-label flex-1 truncate">{{ $menu->nama_menu }}</span>
                <i class="sidebar-chevron fas fa-chevron-down text-xs transition-transform duration-200 {{ $isActive ? 'rotate-180' : '' }} group-hover:translate-y-0.5"></i>
            </a>

            <!-- Submenu -->
            <div class="submenu-container {{ $isActive ? 'show' : '' }}" id="submenu-{{ $menu->id }}">
                <div class="mt-1 ml-2 pl-4 border-l-2 border-white/10 space-y-0.5">
                    @foreach($menu->children as $child)
                    @php
                    $hasGrandchildren = $child->children && $child->children->count() > 0;
                    $childActive = Request::is(ltrim($child->url, '/') . '*');

                    if ($hasGrandchildren) {
                    foreach($child->children as $grandchild) {
                    if (Request::is(ltrim($grandchild->url, '/') . '*')) {
                    $childActive = true;
                    break;
                    }
                    }
                    }
                    @endphp

                    @if($hasGrandchildren)
                    <!-- Child with Grandchildren -->
                    <a href="#submenu-{{ $child->id }}"
                        data-toggle="submenu"
                        aria-expanded="{{ $childActive ? 'true' : 'false' }}"
                        title="{{ $child->nama_menu }}"
                        class="menu-item-child flex items-center px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ $childActive ? 'text-blue-400 bg-blue-500/10' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5' }}">
                        <span class="menu-icon w-4 flex items-center justify-center mr-2 flex-shrink-0">
                            <i class="{{ $child->icon ?? 'fas fa-folder' }} text-xs"></i>
                        </span>
                        <span class="sidebar-menu-label flex-1 truncate">{{ $child->nama_menu }}</span>
                        <i class="sidebar-chevron fas fa-chevron-down text-[10px] transition-transform duration-200 {{ $childActive ? 'rotate-180' : '' }}"></i>
                    </a>

                    <!-- Grandchildren -->
                    <div class="submenu-container {{ $childActive ? 'show' : '' }}" id="submenu-{{ $child->id }}">
                        <div class="mt-0.5 ml-2 pl-3 border-l border-white/10 space-y-0.5">
                            @foreach($child->children as $grandchild)
                            @php $grandchildActive = Request::is(ltrim($grandchild->url, '/') . '*'); @endphp
                            <a href="{{ url($grandchild->url) }}"
                                title="{{ $grandchild->nama_menu }}"
                                class="menu-item-grandchild flex items-center px-2 py-1.5 rounded-lg text-xs transition-all duration-200 {{ $grandchildActive ? 'text-blue-400 bg-blue-500/10 font-medium' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5' }}">
                                <span class="menu-icon w-1.5 h-1.5 rounded-full mr-2 flex-shrink-0 {{ $grandchildActive ? 'bg-blue-400' : 'bg-gray-500' }}"></span>
                                <span class="sidebar-menu-label truncate">{{ $grandchild->nama_menu }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <!-- Child without Grandchildren -->
                    <a href="{{ url($child->url) }}"
                        title="{{ $child->nama_menu }}"
                        class="menu-item-child flex items-center px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ $childActive ? 'text-blue-400 bg-blue-500/10' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5' }}">
                        <span class="menu-icon w-1.5 h-1.5 rounded-full mr-3 flex-shrink-0 {{ $childActive ? 'bg-blue-400' : 'bg-gray-500' }}"></span>
                        <span class="sidebar-menu-label truncate">{{ $child->nama_menu }}</span>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @else
            <!-- Single Menu -->
            <a href="{{ url($menu->url) }}"
                title="{{ $menu->nama_menu }}"
                class="menu-item-parent flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 group {{ $isActive ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <span class="menu-icon w-5 flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="{{ $menu->icon ?? 'fas fa-circle' }}"></i>
                </span>
                <span class="sidebar-menu-label flex-1 truncate">{{ $menu->nama_menu }}</span>
            </a>
            @endif
        </div>
        @endforeach
        @else
        <div class="text-center py-8 px-4">
            <i class="fas fa-inbox text-4xl text-gray-600 mb-3 opacity-30"></i>
            <p class="text-xs text-gray-500">No menus available</p>
        </div>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 mt-auto border-t border-white/10 relative z-10">
        <a href="#"
            onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();"
            title="Logout"
            class="logout-btn flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors duration-200 shadow-sm group">
            <i class="fas fa-sign-out-alt text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
            <span class="sidebar-logout-label">Logout</span>
        </a>
        <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>

<script>
    // Immediate execution - no waiting for DOMContentLoaded
    (function() {
        'use strict';

        console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        console.log('🚀 SIDEBAR INITIALIZATION START');
        console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Function to initialize sidebar
        function initSidebar() {
            // Close button functionality
            const closeBtn = document.getElementById('sidebar-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.getElementById('wrapper').classList.remove('toggled');
                    console.log('✓ Sidebar closed via close button');
                });
            }

            // Get all menu toggles
            const menuToggles = document.querySelectorAll('#sidebar-wrapper a[data-toggle="submenu"]');
            console.log('📋 Found', menuToggles.length, 'menu toggles');

            if (menuToggles.length === 0) {
                console.warn('⚠️ No menu toggles found! Check if data-toggle="submenu" exists');
                return;
            }

            // Initialize each menu toggle
            menuToggles.forEach(function(toggle, index) {
                const targetId = toggle.getAttribute('href');
                if (!targetId || targetId === '#') {
                    console.warn('⚠️ Invalid href for toggle', index);
                    return;
                }

                const targetElement = document.getElementById(targetId.substring(1));

                if (!targetElement) {
                    console.warn('⚠️ Target not found:', targetId);
                    return;
                }

                // Get menu name
                const menuName = toggle.textContent.trim();

                // Get initial state based on aria-expanded
                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

                console.log(`  ${isExpanded ? '✓' : '○'} ${index + 1}. "${menuName}" - ${isExpanded ? 'EXPANDED (active)' : 'collapsed'}`);

                // Add click handler
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const wrapper = document.getElementById('wrapper');
                    if (window.innerWidth >= 1024 && wrapper && wrapper.classList.contains('toggled')) {
                        return;
                    }

                    const isCurrentlyExpanded = this.getAttribute('aria-expanded') === 'true';
                    const chevron = this.querySelector('.fa-chevron-down');
                    const target = document.getElementById(this.getAttribute('href').substring(1));

                    if (!target) {
                        console.error('❌ Target element not found!');
                        return;
                    }

                    if (isCurrentlyExpanded) {
                        // Collapse
                        target.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                        if (chevron) chevron.classList.remove('rotate-180');
                        console.log('▼ Collapsed:', menuName);
                    } else {
                        // Expand
                        target.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        if (chevron) chevron.classList.add('rotate-180');
                        console.log('▲ Expanded:', menuName);
                    }
                });
            });

            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            console.log('✅ SIDEBAR INITIALIZED SUCCESSFULLY!');
            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        }

        // Try to initialize immediately
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSidebar);
        } else {
            initSidebar();
        }
    })();
</script>

<style>
    /* Submenu container - Simple and effective */
    .submenu-container {
        overflow: hidden;
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        max-height: 0;
        opacity: 0;
    }

    .submenu-container.show {
        max-height: 1000px;
        opacity: 1;
    }

    /* Custom Scrollbar */
    #sidebar-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    #sidebar-wrapper::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
    }

    #sidebar-wrapper::-webkit-scrollbar-thumb {
        background: rgba(96, 165, 250, 0.45);
        border-radius: 3px;
    }

    #sidebar-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(96, 165, 250, 0.65);
    }
</style>
