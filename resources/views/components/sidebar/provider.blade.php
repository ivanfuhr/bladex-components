@props([
    'defaultOpen' => true,
    'storageKey' => 'stencil-sidebar-state',
    'width' => '16rem',
    'widthIcon' => '3rem',
    'widthMobile' => '18rem',
])

@php
    $isDefaultOpen = (bool) $defaultOpen;
@endphp

<div {{
    $attributes->class([
        'sidebar-provider',
        'group/sidebar-wrapper flex min-h-svh w-full has-data-[variant=inset]:bg-zinc-100 dark:has-data-[variant=inset]:bg-zinc-950',
    ])->merge([
        'data-sidebar-provider' => true,
        'data-default-open' => $isDefaultOpen ? 'true' : 'false',
        'data-storage-key' => (string) $storageKey,
        'data-state' => $isDefaultOpen ? 'expanded' : 'collapsed',
        'data-open' => $isDefaultOpen ? 'true' : 'false',
        'data-mobile' => 'false',
        'data-mobile-open' => 'false',
        'style' => '--stencil-sidebar-width: '.e($width).'; --stencil-sidebar-width-icon: '.e($widthIcon).'; --stencil-sidebar-width-mobile: '.e($widthMobile).';',
    ])
}}>
    {{ $slot }}
</div>
