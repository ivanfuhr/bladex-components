<li {{
    $attributes->class([
        'pagination__item',
    ])->merge([
        'data-pagination-item' => true,
    ])
}}>
    {{ $slot }}
</li>
