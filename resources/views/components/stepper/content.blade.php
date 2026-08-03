<div {{
    $attributes->except(['id'])->class([
        'stepper__content',
        'min-w-0 flex-1 text-sm text-zinc-700 focus-visible:outline-none dark:text-zinc-300',
        ! $isSelected ? 'hidden' : null,
        $isVertical ? null : 'w-full',
    ])->merge([
        'id' => $panelId,
        'role' => 'region',
        'aria-labelledby' => $triggerId,
        'data-stepper-content' => true,
        'data-value' => (string) $stepValue,
        'data-state' => $isSelected ? 'active' : 'inactive',
        'tabindex' => '0',
        'hidden' => $isSelected ? null : true,
    ])
}}>
    {{ $slot }}
</div>
