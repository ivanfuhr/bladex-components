@props([
    'level' => 3,
])

@php
    $level = max(1, min(6, (int) $level));
@endphp

<h{{ $level }}
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
</h{{ $level }}>
