<h{{ $resolvedLevel }}
    {{
        $attributes->class([
            'empty__title',
            'text-lg font-medium tracking-tight',
        ])->merge([
            'data-empty-title' => true,
        ])
    }}
>
    {{ $slot }}
</h{{ $resolvedLevel }}>
