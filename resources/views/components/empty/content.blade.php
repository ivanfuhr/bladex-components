<div {{
    $attributes->class([
        'empty__content',
        'flex w-full max-w-sm min-w-0 flex-col items-center gap-4 text-sm text-balance',
    ])->merge([
        'data-empty-content' => true,
    ])
}}>
    {{ $slot }}
</div>
