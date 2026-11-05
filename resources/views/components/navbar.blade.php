<nav
    x-data="{
        mobileOpen: false,
        userOpen: false,
    }"
    @keydown.escape="mobileOpen = false; userOpen = false"
    class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-xs"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 flex-shrink-0 group">
                <div class="bg-blue-600 group-hover:bg-blue-700 transition-colors rounded-xl p-2 shadow-sm">
                    <i data-lucide="shield" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-extrabold text-xl text-slate-900 tracking-tight">VERIFY</span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-1">
                @php
                    $navLinks = [
                        ['route' => 'dashboard',         'label' => 'Dashboard'],
                        ['route' => 'modules.index',     'label' => 'Modules'],
                        ['route' => 'resources.index',   'label' => 'Resources'],
                        ['route' => 'check-link.index',  'label' => 'Check Link'],
                        ['route' => 'how-it-works.index','label' => 'How It Works'],
                        ['route' => 'simulator.index',   'label' => 'Scam Simulator'],
                    ];
                @endphp

                @foreach ($navLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors duration-150
                            {{ request()->routeIs($link['route'] . '*')
                                ? 'text-blue-600 bg-blue-50/80'
                                : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}"
                    >{{ $link['label'] }}</a>
                @endforeach
            </div>

            {{-- Right Side Auth --}}
            <div class="flex items-center gap-3">

                @guest
                    <a
                        href="{{ route('login') }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition"
                    >Login</a>
                    <a
                        href="{{ route('register') }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition"
                    >Register</a>
                @endguest

                @auth
                    {{-- User Dropdown --}}
                    <div
                        x-data="{ open: false }"
                        class="relative"
                        @click.outside="open = false"
                    >
                        <button
                            @click="open = !open"
                            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition-colors"
                            aria-label="User menu"
                            :aria-expanded="open"
                        >
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-semibold text-slate-800 max-w-[120px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            <i data-lucide="chevron-down"
                               class="w-4 h-4 text-slate-400 transition-transform duration-150"
                               :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            x-cloak
                            class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 origin-top-right"
                        >
                            <div class="px-4 py-2 border-b border-slate-100 mb-1">
                                <p class="text-xs text-slate-400 leading-none">Masuk sebagai</p>
                                <p class="text-sm font-bold text-slate-900 mt-1 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition-colors">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-500 flex-shrink-0"></i>
                                    Admin Panel
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                            @endif

                            <a href="{{ route('profile.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                                My Profile
                            </a>
                            <a href="{{ route('history.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="history" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                                Check History
                            </a>
                            <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="settings" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                                Account Settings
                            </a>

                            <div class="border-t border-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                >
                                    <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                {{-- Mobile Hamburger --}}
                <button
                    @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors"
                    :aria-expanded="mobileOpen"
                    aria-label="Toggle mobile menu"
                >
                    <i data-lucide="menu" x-show="!mobileOpen" class="w-6 h-6"></i>
                    <i data-lucide="x" x-show="mobileOpen" x-cloak class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        x-cloak
        class="md:hidden border-t border-slate-200 bg-white"
    >
        <div class="px-4 py-3 space-y-1">
            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @click="mobileOpen = false"
                    class="flex items-center px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors duration-150
                        {{ request()->routeIs($link['route'] . '*')
                            ? 'text-blue-600 bg-blue-50'
                            : 'text-slate-700 hover:text-blue-600 hover:bg-slate-50' }}"
                >{{ $link['label'] }}</a>
            @endforeach
        </div>

        @guest
            <div class="px-4 py-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl text-sm font-semibold text-blue-600 border border-blue-600 hover:bg-blue-50 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                    Register
                </a>
            </div>
        @endguest

        @auth
            <div class="px-4 py-3 border-t border-slate-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-1">
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition-colors">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Admin Panel
                        </a>
                    @endif
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> My Profile
                    </a>
                    <a href="{{ route('history.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="history" class="w-4 h-4 text-slate-400"></i> Check History
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="settings" class="w-4 h-4 text-slate-400"></i> Account Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-1 border-t border-slate-100 mt-1">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
