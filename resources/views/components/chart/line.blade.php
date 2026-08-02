@props([
    'field' => 'value',
    'curve' => null,
])

<template data-chart-template="line" data-field="{{ $field }}" @if (filled($curve)) data-curve="{{ $curve }}" @endif>
    <path
        {{
            $attributes->class('text-zinc-800 dark:text-zinc-100')->merge([
                'stroke' => 'currentColor',
                'stroke-width' => '2',
                'fill' => 'none',
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
            ])
        }}
    ></path>
</template>
