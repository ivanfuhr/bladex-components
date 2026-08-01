@props([
    'align' => 'start',
    'side' => 'bottom',
])

<div {{
    $attributes->class([
        'popover',
        'relative inline-flex',
    ])->merge([
        'data-popover' => true,
        'data-align' => $align,
        'data-side' => $side,
    ])
}}>
    {{ $slot }}
</div>
