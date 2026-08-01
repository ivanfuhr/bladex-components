<button
    type="button"
    {{
        $attributes->class([
            'sidebar__backdrop',
            'fixed inset-0 z-20 bg-zinc-950/40 backdrop-blur-[1px]',
            'pointer-events-none opacity-0',
            'group-data-[mobile-open=true]:pointer-events-auto group-data-[mobile-open=true]:opacity-100',
            'md:hidden',
            'motion-safe:transition-opacity motion-safe:duration-200',
        ])->merge([
            'data-sidebar-backdrop' => true,
            'aria-label' => $attributes->get('aria-label', 'Close sidebar'),
            'tabindex' => '-1',
        ])
    }}
></button>
