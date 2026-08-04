<li {{
    $attributes->except(['id'])->class([
        'stepper__item',
        'group/step relative flex min-w-0',
        $isVertical
            ? 'w-full flex-col'
            : 'flex-1 flex-col items-center isolate',
        $isDisabled ? 'pointer-events-none opacity-50' : null,
    ])->merge([
        'data-stepper-item' => true,
        'data-value' => (string) $value,
        'data-step' => filled($step) ? (string) $step : null,
        'data-state' => $state,
        'data-disabled' => $isDisabled ? 'true' : null,
    ])
}}>
    @unless ($isVertical)
        <div
            class="pointer-events-none absolute inset-x-0 top-0 -z-10 flex h-8 w-full items-center"
            aria-hidden="true"
        >
            <div
                data-stepper-connector-start
                @class([
                    'stepper__connector-start h-px flex-1 min-w-0 bg-zinc-200 dark:bg-zinc-800',
                    'group-data-[state=active]/step:bg-zinc-900 group-data-[state=completed]/step:bg-zinc-900',
                    'dark:group-data-[state=active]/step:bg-zinc-100 dark:group-data-[state=completed]/step:bg-zinc-100',
                ])
            ></div>
            <div class="size-8 shrink-0"></div>
            <div
                data-stepper-separator
                @class([
                    'stepper__separator h-px flex-1 min-w-0 bg-zinc-200 dark:bg-zinc-800',
                    'group-data-[state=completed]/step:bg-zinc-900 dark:group-data-[state=completed]/step:bg-zinc-100',
                ])
            ></div>
        </div>
    @endunless

    {{ $slot }}
</li>
