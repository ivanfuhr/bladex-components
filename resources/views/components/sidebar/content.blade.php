<div {{
    $attributes->class([
        'sidebar__content',
        // flex-1 + min-h-0: fill space between header/footer and scroll when nav overflows.
        // Do not use overflow-hidden in icon mode — it clips items above a sticky footer.
        'flex min-h-0 flex-1 flex-col gap-2 overflow-x-hidden overflow-y-auto',
    ])->merge([
        'data-sidebar-content' => true,
    ])
}}>
    {{ $slot }}
</div>
