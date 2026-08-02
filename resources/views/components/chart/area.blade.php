@aware(['field' => null])

@props([
    'field' => 'value',
    'curve' => null,
])

<template data-chart-template="area" data-field="{{ $field }}" @if (filled($curve)) data-curve="{{ $curve }}" @endif>
    <path {{ $attributes->except('curve')->merge(['fill' => 'currentColor']) }}></path>
</template>
