@props(['resource'])

@php
    $sourceColors = [
        'government'  => 'bg-blue-100 text-blue-700 border-blue-200',
        'ngo'         => 'bg-green-100 text-green-700 border-green-200',
        'academic'    => 'bg-purple-100 text-purple-700 border-purple-200',
        'news'        => 'bg-orange-100 text-orange-700 border-orange-200',
        'tool'        => 'bg-teal-100 text-teal-700 border-teal-200',
        'guide'       => 'bg-amber-100 text-amber-700 border-amber-200',
        'video'       => 'bg-rose-100 text-rose-700 border-rose-200',
        'other'       => 'bg-slate-100 text-slate-600 border-slate-200',
    ];

    $sourceKey  = strtolower($resource->source_type ?? 'other');
    $badgeClass = $sourceColors[$sourceKey] ?? $sourceColors['other'];
@endphp

<article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-200 group">

    <div class="p-5 flex flex-col flex-1">

        {{-- Header: source badge + external link icon --}}
        <div class="flex items-start justify-between gap-2 mb-3">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                <i data-lucide="tag" class="w-3 h-3"></i>
                {{ ucfirst($resource->source_type ?? 'Other') }}
            </span>

            <a
                href="{{ $resource->url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex-shrink-0 p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                aria-label="Open external link"
                title="Open in new tab"
            >
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>

        {{-- Source / Publisher --}}
        @if (!empty($resource->publisher))
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">
                {{ $resource->publisher }}
            </p>
        @endif

        {{-- Title --}}
        <h3 class="font-semibold text-slate-900 text-base mb-2 leading-snug group-hover:text-blue-600 transition-colors duration-150 line-clamp-2">
            {{ $resource->title }}
        </h3>

        {{-- Description --}}
        <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 flex-1 mb-4">
            {{ $resource->description }}
        </p>

        {{-- Footer: domain + CTA --}}
        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
            <span class="text-xs text-slate-400 flex items-center gap-1 truncate max-w-[55%]">
                <i data-lucide="globe" class="w-3 h-3 flex-shrink-0"></i>
                <span class="truncate">{{ parse_url($resource->url, PHP_URL_HOST) ?? $resource->url }}</span>
            </span>

            <a
                href="{{ $resource->url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors flex-shrink-0"
            >
                Visit
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    </div>
</article>
