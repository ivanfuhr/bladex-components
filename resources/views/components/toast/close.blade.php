<button
    type="button"
    {{
        $attributes->class([
            'toast__close',
            'absolute right-1.5 top-1.5 inline-flex size-8 min-h-8 min-w-8 items-center justify-center rounded-md opacity-70 transition hover:opacity-100',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
        ])->merge([
            'data-toast-close' => true,
            'aria-label' => __('Dismiss'),
        ])
    }}
>
    <x-ui::icon name="x" class="size-3.5" />
</button>
