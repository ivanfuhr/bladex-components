@props([
    'asChild' => false,
])

@php
    $classes = [
        'sidebar__group-action',
        'absolute top-3.5 right-3 flex aspect-square size-5 items-center justify-center rounded-md p-0 text-zinc-500 outline-none',
        'ring-zinc-950/10 transition-transform hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
        'dark:text-zinc-400 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        '[&>svg]:size-4 [&>svg]:shrink-0',
        'after:absolute after:-inset-2 md:after:hidden',
        'group-data-[collapsible=icon]:hidden',
    ];
@endphp

@if ($asChild)
    <div {{ $attributes->class([...$classes, 'contents'])->merge(['data-sidebar-group-action' => true]) }}>
        {{ $slot }}
    </div>
@else
    <button
        type="button"
        {{ $attributes->class($classes)->merge(['data-sidebar-group-action' => true]) }}
    >
        {{ $slot }}
    </button>
@endif
