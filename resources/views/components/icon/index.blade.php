@props([
    'name',
    'variant' => 'outline',
])

@php
    $iconAttributes = $attributes->except(['name', 'variant']);
@endphp

@include('std-components::icons.'.$icon, [
    'variant' => $variant,
    'attributes' => $iconAttributes,
])
