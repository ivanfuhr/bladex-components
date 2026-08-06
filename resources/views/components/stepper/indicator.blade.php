<span {{
    $attributes->class([
        'stepper__indicator',
        'relative z-10 flex size-8 shrink-0 items-center justify-center rounded-full border text-sm font-medium transition-colors',
        'border-zinc-200 bg-white text-zinc-600',
        'group-data-[state=active]/step:border-zinc-900 group-data-[state=active]/step:bg-zinc-900 group-data-[state=active]/step:text-zinc-50',
        'group-data-[state=completed]/step:border-zinc-900 group-data-[state=completed]/step:bg-zinc-900 group-data-[state=completed]/step:text-zinc-50',
        'dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300',
        'dark:group-data-[state=active]/step:border-zinc-100 dark:group-data-[state=active]/step:bg-zinc-100 dark:group-data-[state=active]/step:text-zinc-900',
        'dark:group-data-[state=completed]/step:border-zinc-100 dark:group-data-[state=completed]/step:bg-zinc-100 dark:group-data-[state=completed]/step:text-zinc-900',
    ])->merge([
        'data-stepper-indicator' => true,
        'aria-hidden' => 'true',
    ])
}}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <span
            @class([
                'stepper__indicator-number',
                $isCompleted ? 'hidden' : 'inline-flex',
                'group-data-[state=completed]/step:hidden',
            ])
        >{{ $label }}</span>
        <span @class([
            'stepper__indicator-check',
            $isCompleted ? 'inline-flex' : 'hidden',
            'group-data-[state=completed]/step:inline-flex group-data-[state=active]/step:hidden group-data-[state=inactive]/step:hidden',
        ])>
            <x-std::icon name="check" class="size-4" />
        </span>
    @endif
</span>
