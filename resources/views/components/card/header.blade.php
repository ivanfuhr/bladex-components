<div {{
    $attributes->class([
        'card__header',
        'flex flex-col gap-1.5',
    ])->merge([
        'data-card-header' => true,
    ])
}}>
    {{ $slot }}
</div>
