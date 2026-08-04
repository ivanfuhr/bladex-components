<div {{
    $attributes->class([
        'sidebar-provider',
        'relative flex min-h-0 w-full flex-row overflow-hidden has-data-[variant=inset]:bg-zinc-100 dark:has-data-[variant=inset]:bg-zinc-950',
        'group/sidebar-wrapper',
    ])->merge([
        'data-sidebar-provider' => true,
        'data-default-open' => $isDefaultOpen ? 'true' : 'false',
        'data-storage-key' => (string) $storageKey,
        'data-state' => $isDefaultOpen ? 'expanded' : 'collapsed',
        'data-open' => $isDefaultOpen ? 'true' : 'false',
        'data-mobile' => 'false',
        'data-mobile-open' => 'false',
        'style' => $style,
    ])
}}>
    {{ $slot }}
</div>
