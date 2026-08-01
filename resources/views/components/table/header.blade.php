<thead {{
    $attributes->class([
        'table__header',
        '[&_tr]:border-b',
    ])->merge([
        'data-table-header' => true,
    ])
}}>
    {{ $slot }}
</thead>
