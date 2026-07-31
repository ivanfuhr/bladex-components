@props([
    'variant' => 'primary',
])

<x-stencil::button :variant="$variant" {{ $attributes }}> {{ $slot }} </x-stencil::button>
