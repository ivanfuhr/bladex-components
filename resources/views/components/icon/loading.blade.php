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
    {{ $attributes->class([$iconClasses, 'animate-spin']) }}
    width="{{ $pixelSize }}"
    height="{{ $pixelSize }}"
    data-bladex-icon
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="{{ $strokeWidth }}"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
>
    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
</svg>
