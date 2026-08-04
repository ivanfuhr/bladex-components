<th {{
    $attributes->class([
        'table__head',
        'h-10 px-3 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400',
        '[&:has([role=checkbox])]:pr-0',
    ])->merge([
        'data-table-head' => true,
        'data-sortable' => $sortable ? 'true' : null,
        'data-sorted' => $sorted ? 'true' : null,
        'scope' => 'col',
        'aria-sort' => $sorted ? ($direction === 'desc' ? 'descending' : 'ascending') : ($sortable ? 'none' : null),
    ])
}}>
    {{ $slot }}
</th>
