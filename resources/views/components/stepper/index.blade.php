<nav {{
    $attributes->except('aria-label')->class([
        'stepper',
        'flex w-full',
        $isVertical ? 'flex-row gap-8' : 'flex-col gap-6',
    ])->merge([
        'aria-label' => $attributes->get('aria-label', __('Steps')),
        'data-stepper' => true,
        'data-stepper-id' => $stepperId,
        'data-orientation' => $isVertical ? 'vertical' : 'horizontal',
        'data-linear' => $linear ? 'true' : 'false',
        'data-active' => filled($defaultValue) ? (string) $defaultValue : null,
    ])
}}>
    {{ $slot }}
</nav>
