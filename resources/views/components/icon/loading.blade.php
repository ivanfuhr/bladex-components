@props([
    'variant' => 'outline',
])

@include('stencil::internals.loading-icon', [
    'variant' => $variant,
    'class' => $attributes->get('class'),
])
