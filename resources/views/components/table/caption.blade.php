<caption {{
    $attributes->class([
        'table__caption',
        'mt-4 text-sm text-zinc-500 dark:text-zinc-400',
    ])->merge([
        'data-table-caption' => true,
    ])
}}>
    {{ $slot }}
</caption>
