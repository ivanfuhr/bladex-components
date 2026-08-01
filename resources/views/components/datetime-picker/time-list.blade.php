<div
    {{
        $attributes->class([
            // Mobile: stacked under the calendar with a capped scroll area.
            'max-h-60 overflow-y-auto border-t border-zinc-200 p-2',
            // Desktop: inset to match calendar padding; height tracks the month grid.
            'md:absolute md:inset-y-4 md:end-3 md:max-h-none md:w-36 md:border-s md:border-t-0 md:ps-2',
            'dark:border-zinc-800',
        ])
    }}
    data-datetime-picker-time-list
></div>
