<div {{
    $attributes->class([
        'alert__description',
        'text-sm',
    ])->merge([
        'data-alert-description' => true,
    ])
}}>
    {{ $slot }}
</div>
