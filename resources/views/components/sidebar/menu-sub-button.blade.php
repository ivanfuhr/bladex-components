@props([
    'href' => null,
    'active' => false,
    'size' => 'md',
    'asChild' => false,
])

@php
    $isActive = (bool) $active;
    $useLink = filled($href);
    $tag = $useLink ? 'a' : 'button';
    $sizeClasses = $size === 'sm' ? 'text-xs' : 'text-sm';

    $classes = [
        'sidebar__menu-sub-button',
        'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 outline-none',
        'text-zinc-700 ring-zinc-950/10 hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2',
        'active:bg-zinc-100 active:text-zinc-950 disabled:pointer-events-none disabled:opacity-50',
        'data-[active=true]:bg-zinc-100 data-[active=true]:text-zinc-950',
        'dark:text-zinc-200 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        'dark:active:bg-zinc-800 dark:data-[active=true]:bg-zinc-800 dark:data-[active=true]:text-zinc-50',
        '[&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0',
        'group-data-[collapsible=icon]:hidden',
        $sizeClasses,
    ];
@endphp

@if ($asChild)
    <div
        {{
            $attributes->class([...$classes, 'contents'])->merge([
                'data-sidebar-menu-sub-button' => true,
                'data-size' => $size,
                'data-active' => $isActive ? 'true' : 'false',
            ])
        }}
    >
        {{ $slot }}
    </div>
@else
    <{{ $tag }}
        {{
            $attributes->class($classes)->merge([
                'type' => $useLink ? null : 'button',
                'href' => $useLink ? $href : null,
                'data-sidebar-menu-sub-button' => true,
                'data-size' => $size,
                'data-active' => $isActive ? 'true' : 'false',
                'aria-current' => ($isActive && $useLink) ? 'page' : null,
            ])
        }}
    >
        {{ $slot }}
    </{{ $tag }}>
@endif
