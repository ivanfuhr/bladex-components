<nav {{
    $attributes->class([
        'breadcrumb',
        'min-w-0 overflow-hidden',
    ])->merge([
        'aria-label' => __('Breadcrumb'),
        'data-breadcrumb' => true,
    ])
}}>
    {{ $slot }}
</nav>
