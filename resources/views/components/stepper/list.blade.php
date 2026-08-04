<ol {{
    $attributes->class([
        'stepper__list',
        'flex',
        $isVertical
        ? 'w-56 shrink-0 flex-col'
        : 'w-full flex-row items-stretch',
    ])->merge([
        'role' => 'list',
        'data-stepper-list' => true,
        'aria-orientation' => $isVertical ? 'vertical' : 'horizontal',
    ])
}}>
    {{ $slot }}
</ol>
