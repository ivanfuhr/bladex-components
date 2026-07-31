@aware([
    'placeholder' => null,
    'size' => null,
])

@props([
    'placeholder' => null,
])

@php
    $resolvedPlaceholder = filled($placeholder) ? $placeholder : null;

    $chipSizeClasses = $size === 'sm'
        ? 'text-xs px-1.5 py-0'
        : 'text-xs px-2 py-0.5';

    $chipClasses = collect([
        'combobox__chip',
        'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
        'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
        $chipSizeClasses,
    ])->implode(' ');

    $chipLabelClasses = 'min-w-0 truncate';
    $chipRemoveClasses = collect([
        'combobox__chip-remove',
        'inline-flex shrink-0 items-center justify-center rounded-sm text-zinc-500 hover:text-zinc-900',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
        'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
        $size === 'sm' ? 'size-3.5' : 'size-4',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class([
        'combobox__chips',
        'flex min-w-0 flex-1 flex-wrap items-center gap-1',
    ])->merge([
        'data-combobox-chips' => true,
        'data-placeholder' => $resolvedPlaceholder !== null ? $resolvedPlaceholder : null,
    ])
}}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>

<template data-combobox-chip-template>
    <span class="{{ $chipClasses }}" data-combobox-chip>
        <span class="{{ $chipLabelClasses }}" data-combobox-chip-label></span>
        <button type="button" class="{{ $chipRemoveClasses }}" data-combobox-chip-remove aria-label="">
            <x-stencil::icon name="x" class="{{ $size === 'sm' ? 'size-3' : 'size-3.5' }}" />
        </button>
    </span>
</template>
