@extends('layouts.app')

@section('title', 'Check Link')

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ --}}
<section class="relative bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white overflow-hidden">

    {{-- Background grid pattern --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: linear-gradient(rgba(37,99,235,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(37,99,235,0.3) 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-blue-600/20 border border-blue-500/30 text-blue-300 text-xs font-semibold tracking-widest uppercase rounded-full px-4 py-1.5 mb-6">
            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
            URL Safety Checker
        </div>

        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight mb-4">
            Check Any Link <span class="text-blue-400">Instantly</span>
        </h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-10">
            Before you click, verify. Our engine uses Google Safe Browsing and advanced heuristic analysis
            to detect phishing, malware, and suspicious URLs in seconds.
        </p>

        {{-- ═══ URL INPUT FORM ═══ --}}
        <div
            x-data="{
                loading: false,
                url: '',
                submitted: false,
                submit() {
                    if (!this.url.trim()) return;
                    this.loading = true;
                    this.submitted = true;
                }
            }"
            class="max-w-2xl mx-auto"
        >
            <form
                action="{{ route('check-link.check') }}"
                method="POST"
                @submit="submit()"
                class="relative"
            >
                @csrf

                {{-- Error display --}}
                @if ($errors->any())
                    <div class="mb-4 flex items-center gap-2 bg-red-500/20 border border-red-400/30 text-red-300 rounded-xl px-4 py-3 text-sm">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                        <span>{{ $errors->first('url') }}</span>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Input --}}
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                            <i data-lucide="link" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <input
                            type="text"
                            name="url"
                            x-model="url"
                            value="{{ old('url') }}"
                            placeholder="Enter URL to verify (e.g. https://example.com)"
                            autocomplete="off"
                            spellcheck="false"
                            class="w-full pl-12 pr-4 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   text-sm font-mono transition-all duration-200"
                        />
                    </div>

                    {{-- Submit button --}}
                    <button
                        type="submit"
                        :disabled="loading"
                        class="inline-flex items-center justify-center gap-2 px-7 py-4 bg-blue-600 hover:bg-blue-500
                               disabled:opacity-70 disabled:cursor-not-allowed
                               text-white font-semibold rounded-xl transition-all duration-200
                               shadow-lg shadow-blue-600/30 hover:shadow-blue-500/40 whitespace-nowrap"
                    >
                        <span x-show="!loading">
                            <i data-lucide="search" class="w-4 h-4 inline -mt-0.5 mr-1"></i>
                            Check Now
                        </span>
                        <span x-show="loading" x-cloak class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Checking…
                        </span>
                    </button>
                </div>

                {{-- Loading progress bar --}}
                <div x-show="loading" x-cloak class="mt-3 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full animate-pulse w-full"></div>
                </div>
            </form>

            {{-- Note --}}
            <p class="mt-5 text-xs text-slate-400 flex items-center justify-center gap-1.5">
                <i data-lucide="info" class="w-3.5 h-3.5"></i>
                We use Google Safe Browsing and heuristic analysis. No automated check guarantees 100% safety.
            </p>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     RECENT HISTORY (authenticated users only)
═══════════════════════════════════════════════════════════ --}}
@if (!empty($recentHistory) && count($recentHistory) > 0)
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-blue-600"></i>
            Recent Checks
        </h2>
        @auth
        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
            View all →
        </a>
        @endauth
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm divide-y divide-slate-100 overflow-hidden">
        @foreach ($recentHistory as $item)
            @php
                $status = $item->status;
                $statusConfig = match($status) {
                    'safe'       => ['bg' => 'bg-emerald-50',  'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'check-circle',    'label' => 'Safe'],
                    'suspicious' => ['bg' => 'bg-amber-50',    'text' => 'text-amber-700',   'border' => 'border-amber-200',   'icon' => 'alert-triangle',  'label' => 'Suspicious'],
                    'dangerous'  => ['bg' => 'bg-red-50',      'text' => 'text-red-700',     'border' => 'border-red-200',     'icon' => 'x-circle',        'label' => 'Dangerous'],
                    default      => ['bg' => 'bg-slate-50',    'text' => 'text-slate-600',   'border' => 'border-slate-200',   'icon' => 'help-circle',     'label' => 'Unknown'],
                };
            @endphp
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 transition-colors">
                <span class="inline-flex items-center gap-1.5 {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['border'] }} text-xs font-semibold rounded-full px-2.5 py-1 flex-shrink-0">
                    <i data-lucide="{{ $statusConfig['icon'] }}" class="w-3 h-3"></i>
                    {{ $statusConfig['label'] }}
                </span>
                <span class="flex-1 text-sm text-slate-700 font-mono truncate" title="{{ $item->url }}">
                    {{ $item->url }}
                </span>
                <span class="text-xs text-slate-400 flex-shrink-0">
                    {{ \Carbon\Carbon::parse($item->checked_at)->diffForHumans() }}
                </span>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════
     TIPS SECTION
═══════════════════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">What to Look For in Suspicious URLs</h2>
        <p class="text-slate-500 text-sm">Common red flags that indicate a URL may be unsafe</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Tip 1: Lookalike Domains --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="eye-off" class="w-6 h-6 text-red-500"></i>
            </div>
            <h3 class="font-semibold text-slate-800 mb-2">Lookalike Domains</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-3">
                Phishing sites mimic trusted brands by substituting characters — <code class="bg-slate-100 px-1 rounded text-xs">paypa1.com</code> instead of <code class="bg-slate-100 px-1 rounded text-xs">paypal.com</code>, or adding hyphens like <code class="bg-slate-100 px-1 rounded text-xs">paypal-secure.tk</code>.
            </p>
            <ul class="text-xs text-slate-400 space-y-1">
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-red-400"></i> Characters replaced with numbers (a → 4, o → 0)</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-red-400"></i> Brand name inside a longer domain</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-red-400"></i> Added words: -secure, -verify, -login</li>
            </ul>
        </div>

        {{-- Tip 2: Suspicious TLDs --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="globe" class="w-6 h-6 text-amber-500"></i>
            </div>
            <h3 class="font-semibold text-slate-800 mb-2">Suspicious Top-Level Domains</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-3">
                Free or low-cost TLDs are frequently abused by scammers because they can be registered anonymously with minimal cost. Legitimate businesses rarely use them.
            </p>
            <div class="flex flex-wrap gap-1.5">
                @foreach (['.tk', '.ml', '.ga', '.cf', '.gq', '.xyz', '.top', '.pw', '.click', '.zip'] as $tld)
                    <span class="bg-amber-50 text-amber-700 border border-amber-200 text-xs font-mono rounded px-2 py-0.5">{{ $tld }}</span>
                @endforeach
            </div>
        </div>

        {{-- Tip 3: URL Structure Red Flags --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-4">
                <i data-lucide="link-2" class="w-6 h-6 text-blue-500"></i>
            </div>
            <h3 class="font-semibold text-slate-800 mb-2">URL Structure Red Flags</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-3">
                The structure of a URL itself can reveal dangerous intent. Unusual patterns are common in automated phishing kits.
            </p>
            <ul class="text-xs text-slate-400 space-y-1">
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-blue-400"></i> IP address instead of a domain (e.g. http://192.168.1.1)</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-blue-400"></i> Excessive subdomains (a.b.c.d.example.com)</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-blue-400"></i> No HTTPS encryption (http:// only)</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-blue-400"></i> Encoded/obfuscated characters (%20, %2F, etc.)</li>
                <li class="flex items-center gap-1.5"><i data-lucide="minus" class="w-3 h-3 text-blue-400"></i> Executable file downloads (.exe, .ps1, .bat)</li>
            </ul>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     BOTTOM CTA STRIP
═══════════════════════════════════════════════════════════ --}}
<section class="bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
        <p class="text-lg font-semibold mb-1">Not sure about a link? Check it first.</p>
        <p class="text-blue-200 text-sm">
            Free, instant, no account required. Protect yourself and your community.
        </p>
    </div>
</section>

@endsection
