@extends('layouts.app')

@section('title', 'Result — ' . parse_url($url, PHP_URL_HOST))

@section('content')

@php
    $status = $result['status'];

    $statusConfig = match ($status) {
        'safe'       => [
            'bg'          => 'bg-emerald-50',
            'border'      => 'border-emerald-200',
            'text'        => 'text-emerald-700',
            'badgeBg'     => 'bg-emerald-600',
            'icon'        => 'check-circle',
            'label'       => 'Safe',
            'heroGrad'    => 'from-emerald-900 via-slate-900 to-slate-900',
            'accentColor' => 'text-emerald-400',
            'ringColor'   => 'ring-emerald-500/40',
            'iconBg'      => 'bg-emerald-500/20',
        ],
        'suspicious' => [
            'bg'          => 'bg-amber-50',
            'border'      => 'border-amber-200',
            'text'        => 'text-amber-700',
            'badgeBg'     => 'bg-amber-500',
            'icon'        => 'alert-triangle',
            'label'       => 'Suspicious',
            'heroGrad'    => 'from-amber-900 via-slate-900 to-slate-900',
            'accentColor' => 'text-amber-400',
            'ringColor'   => 'ring-amber-500/40',
            'iconBg'      => 'bg-amber-500/20',
        ],
        'dangerous'  => [
            'bg'          => 'bg-red-50',
            'border'      => 'border-red-200',
            'text'        => 'text-red-700',
            'badgeBg'     => 'bg-red-600',
            'icon'        => 'x-circle',
            'label'       => 'Dangerous',
            'heroGrad'    => 'from-red-900 via-slate-900 to-slate-900',
            'accentColor' => 'text-red-400',
            'ringColor'   => 'ring-red-500/40',
            'iconBg'      => 'bg-red-500/20',
        ],
        default      => [
            'bg'          => 'bg-slate-50',
            'border'      => 'border-slate-200',
            'text'        => 'text-slate-600',
            'badgeBg'     => 'bg-slate-500',
            'icon'        => 'help-circle',
            'label'       => 'Unknown',
            'heroGrad'    => 'from-slate-800 via-slate-900 to-slate-900',
            'accentColor' => 'text-slate-400',
            'ringColor'   => 'ring-slate-500/40',
            'iconBg'      => 'bg-slate-500/20',
        ],
    };

    $recommendations = match ($status) {
        'safe'       => [
            'title'  => 'Exercise Normal Caution',
            'icon'   => 'shield-check',
            'color'  => 'emerald',
            'items'  => [
                'The URL passed our automated checks — but always stay alert.',
                'Verify the website owner and purpose before entering personal information.',
                'Confirm the connection is HTTPS (padlock icon in your browser).',
                'If anything feels off on the page itself, trust your instincts and leave.',
            ],
        ],
        'suspicious' => [
            'title'  => 'Proceed with Caution',
            'icon'   => 'shield-alert',
            'color'  => 'amber',
            'items'  => [
                'Do NOT enter passwords, personal information, or payment details.',
                'Verify the URL through the official website directly (type it manually).',
                'Contact the sender through a known, trusted channel to confirm the link.',
                'Consider reporting the URL to your organization\'s security team.',
            ],
        ],
        'dangerous'  => [
            'title'  => 'Do Not Visit This URL',
            'icon'   => 'shield-x',
            'color'  => 'red',
            'items'  => [
                'Do NOT click or navigate to this URL under any circumstances.',
                'If you already visited, run a malware scan immediately.',
                'Report the URL to Google (safebrowsing.google.com/safebrowsing/report_phish/).',
                'Warn others who may have received the same link.',
                'If credentials were entered, change them immediately from a safe device.',
            ],
        ],
        default      => [
            'title'  => 'Verify Through Multiple Sources',
            'icon'   => 'shield',
            'color'  => 'slate',
            'items'  => [
                'Our automated check did not detect threats, but could not fully verify.',
                'Cross-check the URL using VirusTotal (virustotal.com) for a second opinion.',
                'Confirm the source of the link through trusted channels.',
                'Be cautious if you received this link unexpectedly or from an unknown sender.',
            ],
        ],
    };
@endphp

{{-- ═══════════════════════════════════════════════════════════
     HERO — STATUS DISPLAY
═══════════════════════════════════════════════════════════ --}}
<section class="relative bg-gradient-to-b {{ $statusConfig['heroGrad'] }} text-white overflow-hidden">

    {{-- Subtle grid --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">

        {{-- Status icon --}}
        <div class="inline-flex items-center justify-center w-20 h-20 {{ $statusConfig['iconBg'] }} ring-4 {{ $statusConfig['ringColor'] }} rounded-full mb-6">
            <i data-lucide="{{ $statusConfig['icon'] }}" class="w-10 h-10 {{ $statusConfig['accentColor'] }}"></i>
        </div>

        {{-- Status badge --}}
        <div class="mb-4">
            <span class="inline-flex items-center gap-2 {{ $statusConfig['badgeBg'] }} text-white text-sm font-bold tracking-wider uppercase rounded-full px-5 py-2 shadow-lg">
                <i data-lucide="{{ $statusConfig['icon'] }}" class="w-4 h-4"></i>
                {{ $statusConfig['label'] }}
            </span>
        </div>

        {{-- Message --}}
        <p class="text-lg text-slate-200 max-w-xl mx-auto leading-relaxed">
            {{ $result['message'] }}
        </p>

        {{-- Cache notice --}}
        @if (!empty($result['from_cache']))
            <p class="mt-3 text-xs text-slate-400 flex items-center justify-center gap-1.5">
                <i data-lucide="database" class="w-3.5 h-3.5"></i>
                Result served from cache (checked recently)
            </p>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════════════════ --}}
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

    {{-- ─── Checked URL card ─── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i data-lucide="link" class="w-4 h-4 text-slate-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Checked URL</p>
                <p class="text-sm font-mono text-slate-700 break-all leading-relaxed">{{ $url }}</p>
                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    Checked at {{ \Carbon\Carbon::parse($result['checked_at'])->format('D, d M Y · H:i') }}
                    &nbsp;·&nbsp;
                    <i data-lucide="cpu" class="w-3 h-3"></i>
                    Source: {{ $result['source'] }}
                </p>
            </div>
        </div>
    </div>

    {{-- ─── Warnings list ─── --}}
    @if (!empty($result['warnings']) && count($result['warnings']) > 0)
        <div class="{{ $statusConfig['bg'] }} border {{ $statusConfig['border'] }} rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold {{ $statusConfig['text'] }} flex items-center gap-2 mb-4">
                <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                Detected Risk Indicators
                <span class="ml-auto text-xs font-normal bg-white/60 border {{ $statusConfig['border'] }} {{ $statusConfig['text'] }} rounded-full px-2.5 py-0.5">
                    {{ count($result['warnings']) }} found
                </span>
            </h3>
            <ul class="space-y-2.5">
                @foreach ($result['warnings'] as $warning)
                    <li class="flex items-start gap-3 text-sm {{ $statusConfig['text'] }}">
                        <i data-lucide="chevron-right" class="w-4 h-4 mt-0.5 flex-shrink-0 opacity-70"></i>
                        <span>{{ $warning }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-2xl shadow-sm p-5 flex items-center gap-3 text-sm text-slate-500">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-400 flex-shrink-0"></i>
            No specific risk indicators were detected during pattern analysis.
        </div>
    @endif

    {{-- ─── Recommendations ─── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 flex items-center gap-2 mb-4">
            <i data-lucide="{{ $recommendations['icon'] }}" class="w-5 h-5 text-{{ $recommendations['color'] }}-500"></i>
            {{ $recommendations['title'] }}
        </h3>
        <ul class="space-y-3">
            @foreach ($recommendations['items'] as $rec)
                <li class="flex items-start gap-3 text-sm text-slate-600">
                    <div class="w-5 h-5 bg-{{ $recommendations['color'] }}-50 border border-{{ $recommendations['color'] }}-200 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="check" class="w-3 h-3 text-{{ $recommendations['color'] }}-500"></i>
                    </div>
                    <span class="leading-relaxed">{{ $rec }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- ─── Disclaimer box ─── --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-start gap-3">
        <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="text-sm font-semibold text-blue-800 mb-1">Disclaimer</p>
            <p class="text-sm text-blue-700 leading-relaxed">{{ $result['disclaimer'] }}</p>
        </div>
    </div>

    {{-- ─── Action buttons ─── --}}
    <div class="flex flex-col sm:flex-row gap-3 pt-2">
        <a
            href="{{ route('check-link.index') }}"
            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5
                   bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl
                   transition-all duration-200 shadow-md shadow-blue-600/20 hover:shadow-blue-500/30"
        >
            <i data-lucide="search" class="w-4 h-4"></i>
            Check Another URL
        </a>

        @auth
        <a
            href="{{ route('dashboard') }}"
            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5
                   bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl
                   transition-all duration-200 shadow-sm"
        >
            <i data-lucide="history" class="w-4 h-4"></i>
            View History
        </a>
        @endauth

        {{-- Share / Copy button --}}
        <button
            x-data="{
                copied: false,
                copy() {
                    navigator.clipboard.writeText('{{ $url }}').then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    });
                }
            }"
            @click="copy()"
            type="button"
            class="sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5
                   bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl
                   transition-all duration-200 shadow-sm text-sm font-medium"
            title="Copy URL to clipboard"
        >
            <i data-lucide="copy" class="w-4 h-4" x-show="!copied"></i>
            <i data-lucide="check" class="w-4 h-4 text-emerald-500" x-show="copied" x-cloak></i>
            <span x-show="!copied">Copy URL</span>
            <span x-show="copied" x-cloak class="text-emerald-600">Copied!</span>
        </button>
    </div>

    {{-- ─── External verification links ─── --}}
    <div class="border-t border-slate-100 pt-6">
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-3">Verify further with</p>
        <div class="flex flex-wrap gap-2">
            <a
                href="https://www.virustotal.com/gui/url/{{ urlencode(base64_encode($url)) }}/detection"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors"
            >
                <i data-lucide="external-link" class="w-3 h-3"></i>
                VirusTotal
            </a>
            <a
                href="https://transparencyreport.google.com/safe-browsing/search?url={{ urlencode($url) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors"
            >
                <i data-lucide="external-link" class="w-3 h-3"></i>
                Google Transparency Report
            </a>
            <a
                href="https://urlscan.io/search/#page.url%3A{{ urlencode(parse_url($url, PHP_URL_HOST)) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors"
            >
                <i data-lucide="external-link" class="w-3 h-3"></i>
                urlscan.io
            </a>
        </div>
    </div>

</section>

@endsection
