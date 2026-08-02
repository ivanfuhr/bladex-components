<main {{
    $attributes->class([
        'sidebar__inset',
        'relative flex w-full flex-1 flex-col bg-white dark:bg-zinc-950',
        'md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ms-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm',
        'md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ms-2',
    ])->merge([
        'data-sidebar-inset' => true,
    ])
}}>
    {{ $slot }}
</main>
