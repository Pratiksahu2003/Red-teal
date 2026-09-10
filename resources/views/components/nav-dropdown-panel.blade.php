@props([
    'show' => 'false',
    'panelRef' => 'panel',
    'width' => 'compact',
    'columns' => 1,
])

@php
    $widthClasses = match ($width) {
        'compact' => 'w-[min(calc(100vw-1.5rem),17rem)]',
        'medium' => 'w-[min(calc(100vw-1.5rem),28rem)]',
        'wide' => 'w-[min(calc(100vw-2rem),36rem)]',
        default => 'w-[min(calc(100vw-1.5rem),28rem)]',
    };

    $gridClasses = match ((int) $columns) {
        3 => 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-5',
        2 => 'grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5',
        default => 'flex flex-col gap-y-5',
    };
@endphp

<div
    x-show="{{ $show }}"
    x-ref="{{ $panelRef }}"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="absolute top-full left-0 pt-1.5 z-50"
>
    <div {{ $attributes->merge(['class' => "{$widthClasses} rounded-xl bg-white border border-brand-200/80 shadow-xl shadow-brand-900/10 overflow-hidden max-h-[min(70vh,calc(100vh-var(--site-header-height)-1rem))]"]) }}>
        <div class="px-4 py-3 overflow-y-auto overscroll-contain">
            <div class="{{ $gridClasses }}">
                {{ $slot }}
            </div>
        </div>

        @isset($footer)
            <div class="px-4 py-2.5 bg-brand-50/80 border-t border-brand-100 shrink-0">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
