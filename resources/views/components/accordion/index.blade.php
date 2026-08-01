@props([
    'exclusive' => false,
    'multiple' => null,
    'transition' => false,
    'variant' => null,
    'bordered' => false,
])

@php
    $isExclusive = $multiple === null
        ? (bool) $exclusive
        : ! (bool) $multiple;
@endphp

<div {{
    $attributes->class([
        'accordion',
        'w-full',
        $bordered ? 'rounded-xl border border-zinc-200 dark:border-zinc-800' : null,
    ])->merge([
        'data-accordion' => true,
        'data-accordion-exclusive' => $isExclusive ? 'true' : 'false',
        'data-accordion-transition' => $transition ? 'true' : 'false',
        'data-accordion-variant' => filled($variant) ? $variant : null,
    ])
}}>
    {{ $slot }}
</div>
