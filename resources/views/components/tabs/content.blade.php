<div {{
    $attributes->except(['id'])->class([
        'tabs__content',
        'mt-2 text-sm text-zinc-700 focus-visible:outline-none dark:text-zinc-300',
        ! $isSelected ? 'hidden' : null,
    ])->merge([
        'id' => $panelId,
        'role' => 'tabpanel',
        'aria-labelledby' => $triggerId,
        'data-tabs-content' => true,
        'data-value' => $tabValue,
        'data-state' => $isSelected ? 'active' : 'inactive',
        'tabindex' => '0',
        'hidden' => $isSelected ? null : true,
    ])
}}>
    {{ $slot }}
</div>
