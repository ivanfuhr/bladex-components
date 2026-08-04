<div {{
    $attributes->class([
        'avatar-group',
        'flex items-center -space-x-2',
        '*:ring-2 *:ring-white dark:*:ring-zinc-950',
    ])->merge(array_filter([
        'data-avatar-group' => true,
        'aria-label' => filled($label) ? $label : null,
        'role' => filled($label) ? 'group' : null,
    ]))
}}>
    {{ $slot }}
</div>
