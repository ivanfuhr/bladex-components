<nav {{
    $attributes->class([
        'breadcrumb',
    ])->merge([
        'aria-label' => __('Breadcrumb'),
        'data-breadcrumb' => true,
    ])
}}>
    {{ $slot }}
</nav>
