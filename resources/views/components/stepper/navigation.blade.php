<div {{
    $attributes->class([
        'stepper__navigation',
        'flex items-center justify-between gap-3',
    ])->merge([
        'data-stepper-navigation' => true,
    ])
}}>
    {{ $slot }}
</div>
