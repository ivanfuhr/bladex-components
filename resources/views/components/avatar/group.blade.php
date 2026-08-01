<div {{
    $attributes->class([
        'avatar-group',
        'flex items-center -space-x-2',
        '*:ring-2 *:ring-white dark:*:ring-zinc-950',
    ])->merge([
        'data-avatar-group' => true,
    ])
}}>
    {{ $slot }}
</div>
