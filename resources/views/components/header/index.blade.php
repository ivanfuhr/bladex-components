<header {{
    $attributes->class($classes)->merge([
        'data-header' => true,
        'data-header-variant' => $isPage ? 'page' : 'shell',
    ])
}}>
    {{ $slot }}
</header>
