<div {{
    $attributes->class([
        'sidebar__footer',
        // Expanded: p-2 + menu-button lg (h-12). Icon: match size-8 rail + shell h-12.
        'flex h-16 shrink-0 flex-col justify-center gap-2 border-t border-zinc-200 p-2 dark:border-zinc-800',
        'group-data-[collapsible=icon]:h-12 group-data-[collapsible=icon]:items-center',
    ])->merge([
        'data-sidebar-footer' => true,
    ])
}}>
    {{ $slot }}
</div>
