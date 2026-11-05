@props(['module'])

@php
    $categoryColors = [
        'phishing'      => 'bg-red-100 text-red-700 border-red-200',
        'social-engineering' => 'bg-orange-100 text-orange-700 border-orange-200',
        'malware'       => 'bg-purple-100 text-purple-700 border-purple-200',
        'password'      => 'bg-blue-100 text-blue-700 border-blue-200',
        'privacy'       => 'bg-teal-100 text-teal-700 border-teal-200',
        'scams'         => 'bg-amber-100 text-amber-700 border-amber-200',
        'ransomware'    => 'bg-rose-100 text-rose-700 border-rose-200',
        'general'       => 'bg-slate-100 text-slate-700 border-slate-200',
    ];

    $categoryIcons = [
        'phishing'           => 'fish',
        'social-engineering' => 'users',
        'malware'            => 'bug',
        'password'           => 'key-round',
        'privacy'            => 'eye-off',
        'scams'              => 'alert-octagon',
        'ransomware'         => 'lock',
        'general'            => 'shield',
    ];

    $slug      = strtolower(str_replace(' ', '-', $module->category ?? 'general'));
    $badgeClass = $categoryColors[$slug] ?? $categoryColors['general'];
    $icon       = $categoryIcons[$slug]  ?? $categoryIcons['general'];
@endphp

<article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-200 group">

    {{-- Card Header accent bar --}}
    <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600 w-0 group-hover:w-full transition-all duration-300 ease-out"></div>

    <div class="p-5 flex flex-col flex-1">

        {{-- Category Badge --}}
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                <i data-lucide="{{ $icon }}" class="w-3 h-3"></i>
                {{ ucfirst($module->category ?? 'General') }}
            </span>

            @if (isset($module->difficulty))
                <span class="text-xs text-slate-400 font-medium">
                    {{ ucfirst($module->difficulty) }}
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h3 class="font-semibold text-slate-900 text-base mb-2 leading-snug group-hover:text-blue-600 transition-colors duration-150">
            {{ $module->title }}
        </h3>

        {{-- Description --}}
        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 flex-1 mb-4">
            {{ $module->description }}
        </p>

        {{-- Meta row --}}
        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
            <div class="flex items-center gap-3 text-xs text-slate-400">
                @if (isset($module->read_time))
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i>
                        {{ $module->read_time }} min read
                    </span>
                @endif
                @if (isset($module->views_count))
                    <span class="flex items-center gap-1">
                        <i data-lucide="eye" class="w-3 h-3"></i>
                        {{ number_format($module->views_count) }}
                    </span>
                @endif
            </div>

            <a
                href="{{ route('modules.show', $module->slug) }}"
                class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors"
            >
                Read More
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
            </a>
        </div>
    </div>
</article>
