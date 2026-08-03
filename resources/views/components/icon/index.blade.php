@props([
    'name',
    'variant' => 'outline',
])

@php
    $iconAttributes = $attributes->except(['name', 'variant']);
@endphp

@include('stencil::icons.'.$icon, [
    'variant' => $variant,
    'attributes' => $iconAttributes,
])
