<td {{
    $attributes->class([
        'table__cell',
        'p-3 align-middle [&:has([role=checkbox])]:pr-0',
        $variant === 'strong' ? 'font-medium text-zinc-950 dark:text-zinc-50' : null,
    ])->merge([
        'data-table-cell' => true,
        'data-variant' => $variant,
    ])
}}>
    {{ $slot }}
</td>
