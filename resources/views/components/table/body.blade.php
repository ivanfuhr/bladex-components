<tbody {{
    $attributes->class([
        'table__body',
        '[&_tr:last-child]:border-0',
    ])->merge([
        'data-table-body' => true,
    ])
}}>
    {{ $slot }}
</tbody>
