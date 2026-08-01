@props([
    'defaultValue' => null,
    'orientation' => 'horizontal',
    'variant' => 'default',
])

<div {{
    $attributes->class([
        'tabs',
        $orientation === 'vertical' ? 'flex gap-4' : 'flex flex-col gap-2',
    ])->merge([
        'data-tabs' => true,
        'data-orientation' => $orientation,
        'data-variant' => $variant,
        'data-active' => filled($defaultValue) ? $defaultValue : null,
    ])
}}>
    {{ $slot }}
</div>
