<{{ $tag }}
    {{
        $attributes->class([
            'dropdown-menu__item',
            'relative flex w-full cursor-default items-center gap-2 rounded-md px-2 py-1.5 text-sm outline-none select-none',
            $isDanger
            ? 'text-red-600 focus:bg-red-50 focus:text-red-700 data-[highlighted]:bg-red-50 data-[highlighted]:text-red-700 dark:text-red-400 dark:focus:bg-red-950/40 dark:data-[highlighted]:bg-red-950/40'
            : 'text-zinc-950 focus:bg-zinc-100 data-[highlighted]:bg-zinc-100 dark:text-zinc-50 dark:focus:bg-zinc-800 dark:data-[highlighted]:bg-zinc-800',
            $isDisabled ? 'pointer-events-none opacity-50' : null,
        ])->merge([
            'type' => $useLink ? null : 'button',
            'href' => $useLink ? $href : null,
            'role' => 'menuitem',
            'tabindex' => '-1',
            'data-dropdown-menu-item' => true,
            'data-variant' => $variant,
            'data-keep-open' => $keepOpen ? 'true' : null,
            'data-disabled' => $isDisabled ? 'true' : null,
            'aria-disabled' => $isDisabled ? 'true' : null,
            'disabled' => (! $useLink && $isDisabled) ? true : null,
        ])
    }}
>
    <span class="min-w-0 flex-1 text-left">{{ $slot }}</span>
    @if (filled($kbd))
        <x-ui::dropdown-menu.shortcut>{{ $kbd }}</x-ui::dropdown-menu.shortcut>
    @endif
</{{ $tag }}>
