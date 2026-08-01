<span {{
    $attributes->class([
        'command__shortcut',
        'ms-auto text-xs tracking-widest text-zinc-400 dark:text-zinc-500',
    ])->merge([
        'data-command-shortcut-hint' => true,
    ])
}}>
    {{ $slot }}
</span>
