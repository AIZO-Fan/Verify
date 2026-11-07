<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ isset($title) ? $title . ' · VERIFY Admin' : 'Admin Panel · VERIFY' }}</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        'primary-dark': '#1D4ED8',
                        navy: '#0F172A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 antialiased" x-data="{ sidebarOpen: true }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="flex-shrink-0 bg-navy text-white flex flex-col transition-all duration-300 ease-in-out overflow-hidden"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-700">
            <div class="flex-shrink-0 bg-blue-600 rounded-lg p-1.5">
                <i data-lucide="shield" class="w-5 h-5 text-white"></i>
            </div>
            <span
                x-show="sidebarOpen"
                x-transition:enter="transition-opacity duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="font-bold text-lg tracking-wide"
            >VERIFY</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 space-y-1 px-2 overflow-y-auto">

            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'label' => 'Dashboard',         'icon' => 'layout-dashboard'],
                    ['route' => 'admin.modules.index',    'label' => 'Learning Modules',  'icon' => 'book-open'],
                    ['route' => 'admin.resources.index',  'label' => 'Resources',         'icon' => 'folder-open'],
                    ['route' => 'admin.users.index',      'label' => 'Users',             'icon' => 'users'],
                    ['route' => 'dashboard',              'label' => 'Back to Site',      'icon' => 'external-link'],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route'] . '*');
                @endphp
                <a
                    href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150
                        {{ $isActive
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                    :class="!sidebarOpen ? 'justify-center' : ''"
                    title="{{ $item['label'] }}"
                >
                    <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 flex-shrink-0"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition:enter="transition-opacity duration-150"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="whitespace-nowrap"
                    >{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Sidebar Footer --}}
        <div class="border-t border-slate-700 p-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-150"
                    :class="!sidebarOpen ? 'justify-center' : ''"
                    title="Logout"
                >
                    <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition:enter="transition-opacity duration-150"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                    >Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                {{-- Sidebar Toggle --}}
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-500 hover:text-slate-800 transition-colors p-1 rounded-md hover:bg-slate-100"
                    aria-label="Toggle sidebar"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div>
                    <h1 class="text-sm font-semibold text-slate-900">Admin Panel</h1>
                    <p class="text-xs text-slate-500 leading-none mt-0.5">{{ isset($title) ? $title : 'Dashboard' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Notifications placeholder --}}
                <button class="relative text-slate-500 hover:text-slate-800 transition-colors p-1.5 rounded-md hover:bg-slate-100">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>

                {{-- User Info --}}
                @auth
                    <div
                        x-data="{ open: false }"
                        class="relative"
                        @click.outside="open = false"
                    >
                        <button
                            @click="open = !open"
                            class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-slate-100 transition-colors"
                        >
                            <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ Auth::user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                        </button>

                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            x-cloak
                            class="absolute right-0 mt-1 w-48 bg-white border border-slate-200 rounded-xl shadow-lg py-1 z-50"
                        >
                            <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> My Profile
                            </a>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="home" class="w-4 h-4 text-slate-400"></i> Main Site
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </header>

        {{-- Flash Messages --}}
        @if (session('success') || session('error') || session('warning') || session('info'))
            <div class="px-6 pt-4">
                @if (session('success'))
                    <x-alert type="success" :message="session('success')" />
                @elseif (session('error'))
                    <x-alert type="error" :message="session('error')" />
                @elseif (session('warning'))
                    <x-alert type="warning" :message="session('warning')" />
                @elseif (session('info'))
                    <x-alert type="info" :message="session('info')" />
                @endif
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

{{-- Lucide Icons Init --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>

@stack('scripts')
</body>
</html>
