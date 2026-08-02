<div {{
    $attributes->class([
        'sidebar__header',
        'flex flex-col gap-2 p-2',
    ])->merge([
        'data-sidebar-header' => true,
    ])
}}>
    {{ $slot }}
</div>
