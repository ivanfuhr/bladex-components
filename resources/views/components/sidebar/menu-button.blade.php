@props([
    'href' => null,
    'active' => false,
    'variant' => 'default',
    'size' => 'default',
    'asChild' => false,
])

@php
    $isActive = (bool) $active;
    $useLink = filled($href);
    $tag = $useLink ? 'a' : 'button';

    $sizeClasses = match ($size) {
        'sm' => 'h-7 text-xs',
        'lg' => 'h-12 text-sm group-data-[collapsible=icon]:p-0!',
        default => 'h-8 text-sm',
    };

    $variantClasses = match ($variant) {
        'outline' => 'bg-white shadow-[0_0_0_1px_rgb(228_228_231)] hover:bg-zinc-100 hover:text-zinc-950 hover:shadow-[0_0_0_1px_rgb(212_212_216)] dark:bg-zinc-950 dark:shadow-[0_0_0_1px_rgb(39_39_42)] dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
        default => 'hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
    };

    $classes = [
        'sidebar__menu-button',
        'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-none',
        'ring-zinc-950/10 transition-[width,height,padding] duration-200 ease-out',
        'group-has-data-[sidebar=menu-action]/menu-item:pe-8',
        'group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2!',
        'focus-visible:ring-2 active:bg-zinc-100 active:text-zinc-950',
        'disabled:pointer-events-none disabled:opacity-50',
        'aria-disabled:pointer-events-none aria-disabled:opacity-50',
        'data-[active=true]:bg-zinc-100 data-[active=true]:font-medium data-[active=true]:text-zinc-950',
        'dark:ring-zinc-300/20 dark:active:bg-zinc-800 dark:active:text-zinc-50',
        'dark:data-[active=true]:bg-zinc-800 dark:data-[active=true]:text-zinc-50',
        '[&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0',
        $sizeClasses,
        $variantClasses,
    ];
@endphp

@if ($asChild)
    <div {{
        $attributes->class([...$classes, 'contents'])->merge([
            'data-sidebar-menu-button' => true,
            'data-size' => $size,
            'data-active' => $isActive ? 'true' : 'false',
        ])
    }}>
        {{ $slot }}
    </div>
@else
    <{{ $tag }}
        {{
            $attributes->class($classes)->merge([
                'type' => $useLink ? null : 'button',
                'href' => $useLink ? $href : null,
                'data-sidebar-menu-button' => true,
                'data-sidebar' => 'menu-button',
                'data-size' => $size,
                'data-active' => $isActive ? 'true' : 'false',
                'aria-current' => ($isActive && $useLink) ? 'page' : null,
            ])
        }}
    >
        {{ $slot }}
    </{{ $tag }}>
@endif
