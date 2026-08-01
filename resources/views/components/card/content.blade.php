<div {{
    $attributes->class([
        'card__content',
    ])->merge([
        'data-card-content' => true,
    ])
}}>
    {{ $slot }}
</div>
