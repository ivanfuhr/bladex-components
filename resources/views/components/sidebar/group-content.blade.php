<div {{
    $attributes->class([
        'sidebar__group-content',
        'w-full text-sm',
    ])->merge([
        'data-sidebar-group-content' => true,
    ])
}}>
    {{ $slot }}
</div>
