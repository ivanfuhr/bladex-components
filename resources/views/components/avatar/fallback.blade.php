<span {{
    $attributes->class([
        'avatar__fallback',
        'flex size-full items-center justify-center',
    ])->merge([
        'data-avatar-fallback' => true,
    ])
}}>
    {{ $slot }}
</span>
