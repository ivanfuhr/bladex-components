@props([
    'variant' => 'outline',
])

@include('bladex-components::internals.loading-icon', [
    'variant' => $variant,
    'class' => $attributes->get('class'),
])
