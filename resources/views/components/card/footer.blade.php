<div {{
    $attributes->class([
        'card__footer',
        'flex items-center gap-2',
    ])->merge([
        'data-card-footer' => true,
    ])
}}>
    {{ $slot }}
</div>
