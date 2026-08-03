<div {{
    $attributes->class([
        'stepper',
        'flex w-full',
        $isVertical ? 'flex-row gap-8' : 'flex-col gap-6',
    ])->merge([
        'data-stepper' => true,
        'data-stepper-id' => $stepperId,
        'data-orientation' => $isVertical ? 'vertical' : 'horizontal',
        'data-linear' => $linear ? 'true' : 'false',
        'data-active' => filled($defaultValue) ? (string) $defaultValue : null,
    ])
}}>
    {{ $slot }}
</div>
