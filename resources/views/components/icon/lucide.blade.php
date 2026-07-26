@props([
    'variant' => 'outline',
])

@php
    use Ivanfuhr\BladexComponents\Support\Icon\IconVariant;

    $normalizedVariant = IconVariant::normalize($variant);
    $iconClasses = IconVariant::classString($normalizedVariant);
    $strokeWidth = IconVariant::strokeWidth($normalizedVariant);
    $pixelSize = IconVariant::pixelSize($normalizedVariant);
@endphp

<svg
    {{ $attributes->class($iconClasses) }}
    width="{{ $pixelSize }}"
    height="{{ $pixelSize }}"
    data-icon
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="{{ $strokeWidth }}"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
>
    {{ $slot }}
</svg>
