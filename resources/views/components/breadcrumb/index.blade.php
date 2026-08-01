<nav {{
    $attributes->class([
        'breadcrumb',
    ])->merge([
        'aria-label' => 'Breadcrumb',
        'data-breadcrumb' => true,
    ])
}}>
    {{ $slot }}
</nav>
