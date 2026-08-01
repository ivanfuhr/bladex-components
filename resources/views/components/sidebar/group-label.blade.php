@props([
    'asChild' => false,
])

@php
    $classes = [
        'sidebar__group-label',
        'flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-zinc-500 outline-none',
        'ring-zinc-950/10 transition-[margin,opacity] duration-200 ease-out focus-visible:ring-2',
        'dark:text-zinc-400 dark:ring-zinc-300/20',
        '[&>svg]:size-4 [&>svg]:shrink-0',
        'group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0',
    ];
@endphp

@if ($asChild)
    <div {{ $attributes->class([...$classes, 'contents'])->merge(['data-sidebar-group-label' => true]) }}>
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->class($classes)->merge(['data-sidebar-group-label' => true]) }}>
        {{ $slot }}
    </div>
@endif
