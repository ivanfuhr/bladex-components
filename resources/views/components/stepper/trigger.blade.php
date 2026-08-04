<button
    type="button"
    {{
        $attributes->except(['id'])->class([
            'stepper__trigger',
            'rounded-lg text-left transition-colors focus-visible:outline-none',
            $isVertical
                ? 'inline-flex w-full items-center gap-3 focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20'
                : 'relative z-10 flex w-full flex-col items-center gap-2 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-zinc-300/20 dark:focus-visible:ring-offset-zinc-950',
            $isDisabled ? 'cursor-not-allowed' : 'cursor-pointer',
        ])->merge([
            'id' => $triggerId,
            'data-stepper-trigger' => true,
            'data-value' => filled($value) ? (string) $value : null,
            'aria-controls' => $panelId,
            'aria-current' => $isCurrent ? 'step' : null,
            'disabled' => $isDisabled ? true : null,
            'tabindex' => $isCurrent ? '0' : '-1',
        ])
    }}
>
    {{ $slot }}
</button>
