<tr {{
    $attributes->class([
        'table__row',
        'border-b border-zinc-200 transition-colors hover:bg-zinc-50/80 dark:border-zinc-800 dark:hover:bg-zinc-900/50',
        'data-[state=selected]:bg-zinc-100 dark:data-[state=selected]:bg-zinc-800',
    ])->merge([
        'data-table-row' => true,
    ])
}}>
    {{ $slot }}
</tr>
