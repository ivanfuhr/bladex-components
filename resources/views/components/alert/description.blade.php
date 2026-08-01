<div {{
    $attributes->class([
        'alert__description',
        'text-sm opacity-90',
    ])->merge([
        'data-alert-description' => true,
    ])
}}>
    {{ $slot }}
</div>
