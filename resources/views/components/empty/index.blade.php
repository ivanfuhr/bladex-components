<div {{
    $attributes->class([
        'empty',
        'flex min-w-0 flex-1 flex-col items-center justify-center gap-6 rounded-xl border-dashed p-6 text-center text-balance md:p-12',
    ])->merge([
        'data-empty' => true,
    ])
}}>
    {{ $slot }}
</div>
