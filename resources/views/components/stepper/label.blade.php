<div {{
    $attributes->class([
        'stepper__label',
        'flex w-full min-w-0 flex-col items-center gap-0.5 text-center',
    ])->merge([
        'data-stepper-label' => true,
    ])
}}>
    {{ $slot }}
</div>
