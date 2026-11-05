@props(['type' => 'info', 'message'])

@php
    $config = match($type) {
        'success' => [
            'wrapper' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'icon'    => 'check-circle',
            'iconCls' => 'text-emerald-500',
            'btnCls'  => 'text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100',
        ],
        'error' => [
            'wrapper' => 'bg-red-50 border-red-200 text-red-800',
            'icon'    => 'x-circle',
            'iconCls' => 'text-red-500',
            'btnCls'  => 'text-red-500 hover:text-red-700 hover:bg-red-100',
        ],
        'warning' => [
            'wrapper' => 'bg-amber-50 border-amber-200 text-amber-800',
            'icon'    => 'alert-triangle',
            'iconCls' => 'text-amber-500',
            'btnCls'  => 'text-amber-500 hover:text-amber-700 hover:bg-amber-100',
        ],
        default => [
            'wrapper' => 'bg-blue-50 border-blue-200 text-blue-800',
            'icon'    => 'info',
            'iconCls' => 'text-blue-500',
            'btnCls'  => 'text-blue-500 hover:text-blue-700 hover:bg-blue-100',
        ],
    };
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    x-cloak
    role="alert"
    class="flex items-start gap-3 border rounded-xl px-4 py-3 {{ $config['wrapper'] }}"
>
    <i data-lucide="{{ $config['icon'] }}" class="w-5 h-5 mt-0.5 flex-shrink-0 {{ $config['iconCls'] }}"></i>

    <div class="flex-1 text-sm font-medium leading-relaxed">
        {{ $message }}
        {{ $slot ?? '' }}
    </div>

    <button
        @click="show = false"
        type="button"
        class="flex-shrink-0 p-1 rounded-lg transition-colors {{ $config['btnCls'] }}"
        aria-label="Dismiss"
    >
        <i data-lucide="x" class="w-4 h-4"></i>
    </button>
</div>
