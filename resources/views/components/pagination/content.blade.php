<ul {{
    $attributes->class([
        'pagination__content',
        'flex flex-row items-center gap-1',
    ])->merge([
        'data-pagination-content' => true,
    ])
}}>
    {{ $slot }}
</ul>
