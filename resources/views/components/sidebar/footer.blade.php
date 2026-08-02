<div {{
    $attributes->class([
        'sidebar__footer',
        'flex flex-col gap-2 p-2',
    ])->merge([
        'data-sidebar-footer' => true,
    ])
}}>
    {{ $slot }}
</div>
