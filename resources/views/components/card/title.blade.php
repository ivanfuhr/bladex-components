<h{{ $resolvedLevel }}
    {{
        $attributes->class([
            'card__title',
            'text-base font-semibold leading-none tracking-tight',
        ])->merge([
            'data-card-title' => true,
        ])
    }}
>
    {{ $slot }}
</h{{ $resolvedLevel }}>
