<div {{
    $attributes->class([
        'empty__header',
        'flex max-w-sm flex-col items-center gap-2 text-center',
    ])->merge([
        'data-empty-header' => true,
    ])
}}>
    {{ $slot }}
</div>
