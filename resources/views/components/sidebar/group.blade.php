<div
    {{
        $attributes->class([
            'sidebar__group',
            'relative flex w-full min-w-0 flex-col p-2',
        ])->merge([
            'data-sidebar-group' => true,
        ])
    }}
>
    {{ $slot }}
</div>
