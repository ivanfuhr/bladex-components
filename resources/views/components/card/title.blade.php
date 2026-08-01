@props([
    'level' => 3,
])

@php
    $level = max(1, min(6, (int) $level));
@endphp

<h{{ $level }}
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
</h{{ $level }}>
