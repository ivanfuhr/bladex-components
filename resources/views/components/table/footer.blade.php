<tfoot {{
    $attributes->class([
        'table__footer',
        'border-t bg-zinc-50 font-medium dark:bg-zinc-900/50 [&>tr]:last:border-b-0',
    ])->merge([
        'data-table-footer' => true,
    ])
}}>
    {{ $slot }}
</tfoot>
