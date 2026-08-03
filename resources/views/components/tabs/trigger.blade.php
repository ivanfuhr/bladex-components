<button
    type="button"
    {{
        $attributes->except(['id'])->class([
            'tabs__trigger',
            'inline-flex items-center justify-center gap-2 whitespace-nowrap transition-colors',
            'text-zinc-600 hover:text-zinc-950 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'disabled:pointer-events-none disabled:opacity-50',
            'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
            $triggerClasses,
        ])->merge([
            'id' => $triggerId,
            'role' => 'tab',
            'data-tabs-trigger' => true,
            'data-value' => $value,
            'data-state' => $isSelected ? 'active' : 'inactive',
            'aria-selected' => $isSelected ? 'true' : 'false',
            'aria-controls' => $panelId,
            'tabindex' => $isSelected ? '0' : '-1',
            'disabled' => $isDisabled ? true : null,
        ])
    }}
>
    {{ $slot }}
</button>
