@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 1 — HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12">

            {{-- Left: Text + Form --}}
            <div class="flex-1 lg:w-3/5 max-w-2xl">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 border border-blue-100">
                    🛡️ Digital Security Platform
                </div>

                {{-- Headline --}}
                <h1 class="text-5xl font-bold text-slate-900 leading-tight mb-5">
                    Think Before<br>You Click.
                </h1>

                {{-- Subtext --}}
                <p class="text-lg text-slate-600 leading-relaxed mb-8">
                    VERIFY is a free cybersecurity awareness platform that helps you detect phishing links,
                    identify online scams, and build digital safety habits. Whether it's a suspicious SMS,
                    a too-good-to-be-true offer, or an unfamiliar website — we've got your back.
                    No sign-up. No tracking. Just protection.
                </p>

                {{-- URL Checker Form --}}
                <form action="{{ route('check-link.check') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="link" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <input
                                type="url"
                                name="url"
                                placeholder="Paste a URL to check, e.g. https://example.com"
                                required
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                            />
                        </div>
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3.5 rounded-xl transition-colors duration-200 whitespace-nowrap flex items-center gap-2 shadow-sm"
                        >
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Check Now
                        </button>
                    </div>
                </form>

                {{-- Trust Signals --}}
                <div class="flex flex-wrap gap-5 text-sm text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</span>
                        No sign-up required
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</span>
                        Instant results
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</span>
                        Free forever
                    </span>
                </div>
            </div>

            {{-- Right: Decorative Shield SVG --}}
            <div class="lg:w-2/5 flex justify-center items-center">
                <div class="relative">
                    {{-- Glow background --}}
                    <div class="absolute inset-0 bg-blue-200 rounded-full blur-3xl opacity-30 scale-110"></div>

                    {{-- Shield SVG --}}
                    <svg viewBox="0 0 200 240" class="relative w-64 h-auto drop-shadow-2xl" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Shield body --}}
                        <path d="M100 10 L185 45 L185 115 C185 165 148 205 100 225 C52 205 15 165 15 115 L15 45 Z"
                              fill="url(#shieldGrad)" stroke="#1D4ED8" stroke-width="3"/>
                        {{-- Inner shield --}}
                        <path d="M100 28 L168 57 L168 115 C168 155 136 190 100 207 C64 190 32 155 32 115 L32 57 Z"
                              fill="url(#shieldInner)" opacity="0.6"/>
                        {{-- Checkmark --}}
                        <path d="M68 118 L88 138 L134 92" stroke="white" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                        {{-- Lock icon hint --}}
                        <circle cx="100" cy="58" r="12" fill="white" opacity="0.15"/>
                        <defs>
                            <linearGradient id="shieldGrad" x1="15" y1="10" x2="185" y2="225" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#3B82F6"/>
                                <stop offset="100%" stop-color="#1D4ED8"/>
                            </linearGradient>
                            <linearGradient id="shieldInner" x1="32" y1="28" x2="168" y2="207" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#93C5FD"/>
                                <stop offset="100%" stop-color="#2563EB"/>
                            </linearGradient>
                        </defs>
                    </svg>

                    {{-- Floating badges --}}
                    <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-lg px-3 py-2 flex items-center gap-2 border border-slate-100">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-xs font-semibold text-slate-700">Safe & Verified</span>
                    </div>
                    <div class="absolute -bottom-2 -left-6 bg-white rounded-xl shadow-lg px-3 py-2 flex items-center gap-2 border border-slate-100">
                        <span class="text-base">🔍</span>
                        <span class="text-xs font-semibold text-slate-700">10K+ URLs Checked</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 2 — STATS BAR
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-slate-900 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-bold text-white mb-1">10,000+</div>
                <div class="text-sm text-slate-400">URLs Checked</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-white mb-1">8</div>
                <div class="text-sm text-slate-400">Learning Modules</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-white mb-1">5</div>
                <div class="text-sm text-slate-400">Scam Scenarios</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-white mb-1">Free</div>
                <div class="text-sm text-slate-400">Always & Open</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 3 — FEATURE CARDS
═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Everything You Need to Stay Safe Online</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">From instant URL analysis to in-depth scam education, VERIFY equips you with the knowledge and tools to navigate the web with confidence.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- URL Checker --}}
            <a href="{{ route('check-link.index') }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-colors">
                    <i data-lucide="search" class="w-6 h-6 text-blue-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">URL Checker</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Instantly verify any suspicious link against threat databases. Get detailed safety reports in seconds.</p>
            </a>

            {{-- Learning Modules --}}
            <a href="{{ route('modules.index') }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition-colors">
                    <i data-lucide="book-open" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">Learning Modules</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Master 8 categories of online scams through structured educational content written by cybersecurity experts.</p>
            </a>

            {{-- Scam Simulator --}}
            <a href="{{ route('simulator.index') }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center mb-4 group-hover:bg-purple-100 transition-colors">
                    <i data-lucide="gamepad-2" class="w-6 h-6 text-purple-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">Scam Simulator</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Practice identifying real scam patterns in a safe environment. Build your instincts without real-world risk.</p>
            </a>

            {{-- Resources --}}
            <a href="{{ route('resources.index') }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                    <i data-lucide="library" class="w-6 h-6 text-emerald-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">Resources</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Curated expert cybersecurity references from BSSN, Kominfo, Google, and leading security organizations.</p>
            </a>

            {{-- Guest Access --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
                    <i data-lucide="unlock" class="w-6 h-6 text-amber-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">Guest Access</h3>
                <p class="text-sm text-slate-600 leading-relaxed">No account required for core features. Check URLs, read modules, and use the simulator without signing in.</p>
            </div>

            {{-- History --}}
            <a href="{{ auth()->check() ? route('history.index') : route('login') }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center mb-4 group-hover:bg-rose-100 transition-colors">
                    <i data-lucide="clock" class="w-6 h-6 text-rose-600"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-2">Check History</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Track and review your past URL checks. Sign in to sync your history across all your devices seamlessly.</p>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 4 — FEATURED MODULES
═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Start Learning Today</h2>
                <p class="text-slate-600">Build your defenses with our most popular security modules.</p>
            </div>
            <a href="{{ route('modules.index') }}" class="hidden sm:flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                View All Modules <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        @if(isset($modules) && $modules->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $module)
            @php
                $categoryColors = [
                    'Phishing'         => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'gradient' => 'from-red-400 to-red-600'],
                    'Shopping'         => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'gradient' => 'from-green-400 to-green-600'],
                    'Investment'       => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'gradient' => 'from-yellow-400 to-yellow-600'],
                    'Social'           => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'gradient' => 'from-purple-400 to-purple-600'],
                    'Fake Websites'    => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'gradient' => 'from-orange-400 to-orange-600'],
                    'Account Takeover' => ['bg' => 'bg-pink-100',   'text' => 'text-pink-700',   'gradient' => 'from-pink-400 to-pink-600'],
                    'OTP'              => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'gradient' => 'from-blue-400 to-blue-600'],
                    'Identity'         => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'gradient' => 'from-indigo-400 to-indigo-600'],
                ];
                $colors = $categoryColors[$module->category] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'gradient' => 'from-slate-400 to-slate-600'];
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
                {{-- Gradient thumbnail --}}
                <div class="h-32 bg-gradient-to-br {{ $colors['gradient'] }} flex items-center justify-center">
                    <i data-lucide="book-open" class="w-10 h-10 text-white opacity-80"></i>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $colors['bg'] }} {{ $colors['text'] }} mb-3 self-start">
                        {{ $module->category }}
                    </span>
                    <h3 class="font-semibold text-slate-900 mb-2 leading-snug line-clamp-2">{{ $module->title }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed line-clamp-3 flex-1">{{ $module->description }}</p>
                    <a href="{{ route('modules.show', $module->slug) }}" class="mt-4 inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors">
                        Read Module <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-slate-400">
            <i data-lucide="book-open" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>
            <p class="text-sm">Modules loading soon.</p>
        </div>
        @endif

        <div class="sm:hidden mt-6 text-center">
            <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                View All Modules <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 5 — HOW IT WORKS
═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">How VERIFY Works</h2>
            <p class="text-slate-600 max-w-xl mx-auto">Three simple steps to know if a URL is safe — powered by real threat intelligence databases.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Connector line (desktop) --}}
            <div class="hidden md:block absolute top-10 left-1/4 right-1/4 h-0.5 bg-blue-100 z-0"></div>

            {{-- Step 1 --}}
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex flex-col items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-200">
                    <span class="text-xs font-bold text-blue-200 mb-0.5">STEP 1</span>
                    <i data-lucide="link" class="w-7 h-7 text-white"></i>
                </div>
                <h3 class="font-semibold text-slate-900 mb-2">Enter URL</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Paste any suspicious link into the checker. We accept any URL format — no need to format it yourself.</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex flex-col items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-200">
                    <span class="text-xs font-bold text-blue-200 mb-0.5">STEP 2</span>
                    <i data-lucide="cpu" class="w-7 h-7 text-white"></i>
                </div>
                <h3 class="font-semibold text-slate-900 mb-2">We Analyze</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Our system cross-references the URL with Google Safe Browsing, VirusTotal, and heuristic pattern detection.</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex flex-col items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-200">
                    <span class="text-xs font-bold text-blue-200 mb-0.5">STEP 3</span>
                    <i data-lucide="shield-check" class="w-7 h-7 text-white"></i>
                </div>
                <h3 class="font-semibold text-slate-900 mb-2">Get Results</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Receive a clear safety verdict with a detailed breakdown of any threats detected, completely free.</p>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('how-it-works.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                Learn More About Our Technology <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 6 — RECENT RESOURCES
═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Educational Resources</h2>
                <p class="text-slate-600">Trusted cybersecurity references from leading authorities.</p>
            </div>
            <a href="{{ route('resources.index') }}" class="hidden sm:flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                Browse All Resources <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        @if(isset($resources) && $resources->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($resources as $resource)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow duration-200 flex flex-col">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="external-link" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $resource->source }}</span>
                    </div>
                </div>
                <h3 class="font-semibold text-slate-900 mb-2 leading-snug line-clamp-2">{{ $resource->title }}</h3>
                <p class="text-sm text-slate-600 leading-relaxed line-clamp-3 flex-1">{{ $resource->description }}</p>
                <a href="{{ $resource->url }}" target="_blank" rel="noopener noreferrer"
                   class="mt-4 inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors">
                    Read Resource <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-slate-400">
            <i data-lucide="library" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>
            <p class="text-sm">Resources loading soon.</p>
        </div>
        @endif

        <div class="sm:hidden mt-6 text-center">
            <a href="{{ route('resources.index') }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-medium text-sm">
                Browse All Resources <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 7 — CTA BANNER (Guests only)
═══════════════════════════════════════════════════════════════ --}}
@guest
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-600 rounded-2xl px-8 py-12 text-center relative overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-500 rounded-full opacity-40"></div>
            <div class="absolute -bottom-16 -right-8 w-56 h-56 bg-blue-700 rounded-full opacity-30"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Browse Safer?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto leading-relaxed">
                    Create a free account to save your URL check history across devices, track your learning progress, and get personalized security tips.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-600 hover:bg-blue-50 font-semibold px-8 py-3 rounded-xl transition-colors duration-200">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Create Free Account
                    </a>
                    <a href="{{ route('how-it-works.index') }}"
                       class="inline-flex items-center justify-center gap-2 border-2 border-blue-400 text-white hover:bg-blue-500 font-semibold px-8 py-3 rounded-xl transition-colors duration-200">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

@endsection
