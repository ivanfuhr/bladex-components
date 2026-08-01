<div
    {{
        $attributes->class([
            'sidebar__content',
            'flex min-h-0 flex-1 flex-col gap-2 overflow-auto group-data-[collapsible=icon]:overflow-hidden',
        ])->merge([
            'data-sidebar-content' => true,
        ])
    }}
>
    {{ $slot }}
</div>
