<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="{{ $description ?? 'VERIFY — Protecting digital citizens through education and cybersecurity awareness.' }}" />
    <title>{{ isset($title) ? $title . ' · VERIFY' : 'VERIFY — Cybersecurity Awareness Platform' }}</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Tailwind custom config --}}
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
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">

    {{-- Flash Messages --}}
    @if (session('success') || session('error') || session('warning') || session('info'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            class="fixed top-16 left-1/2 -translate-x-1/2 z-[9999] w-full max-w-lg px-4"
        >
            @if (session('success'))
                <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 shadow-lg">
                    <i data-lucide="check-circle" class="w-5 h-5 mt-0.5 flex-shrink-0 text-emerald-500"></i>
                    <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @elseif (session('error'))
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 shadow-lg">
                    <i data-lucide="x-circle" class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500"></i>
                    <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @elseif (session('warning'))
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-3 shadow-lg">
                    <i data-lucide="alert-triangle" class="w-5 h-5 mt-0.5 flex-shrink-0 text-amber-500"></i>
                    <span class="text-sm font-medium flex-1">{{ session('warning') }}</span>
                    <button @click="show = false" class="text-amber-500 hover:text-amber-700 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @elseif (session('info'))
                <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-4 py-3 shadow-lg">
                    <i data-lucide="info" class="w-5 h-5 mt-0.5 flex-shrink-0 text-blue-500"></i>
                    <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
                    <button @click="show = false" class="text-blue-500 hover:text-blue-700 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- Navbar --}}
    <x-navbar />

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Lucide Icons Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
