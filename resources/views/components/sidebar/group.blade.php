<div {{
    $attributes->class([
        'sidebar__group',
        'relative flex w-full min-w-0 flex-col p-2',
        // Icon rail is narrow — keep icons centered and avoid double-cramped padding.
        'group-data-[collapsible=icon]:items-center group-data-[collapsible=icon]:px-2',
    ])->merge([
        'data-sidebar-group' => true,
    ])
}}>
    {{ $slot }}
</div>
