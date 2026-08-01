<div {{
    $attributes->class([
        'card__action',
        'col-start-2 row-span-2 row-start-1 self-start justify-self-end',
    ])->merge([
        'data-card-action' => true,
    ])
}}>
    {{ $slot }}
</div>
