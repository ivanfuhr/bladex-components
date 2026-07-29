@aware([
    'size' => null,
])

@php
    $chipSizeClasses = $size === 'sm'
        ? 'text-xs px-1.5 py-0'
        : 'text-xs px-2 py-0.5';

    $chipClasses = collect([
        'select__chip',
        'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
        'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
        $chipSizeClasses,
    ])->implode(' ');
@endphp

<span {{ $attributes->class($chipClasses)->merge(['data-select-chip' => true]) }}>
    <span class="min-w-0 truncate" data-select-chip-label>{{ $slot }}</span>
</span>
