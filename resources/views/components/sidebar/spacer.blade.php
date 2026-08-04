{{--
    Optional flex gap above the footer when content is short.
    Prefer relying on sidebar.content flex-1; keep this for explicit breathing room.
--}}
<div
    {{
        $attributes->class([
            'sidebar__spacer',
            'min-h-0 shrink-0 grow-0',
        ])->merge([
            'data-sidebar-spacer' => true,
        ])
    }}
></div>
