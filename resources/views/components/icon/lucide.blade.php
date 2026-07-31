@props([
    'variant' => 'outline',
])

@php
    use Ivanfuhr\Stencil\Support\Icon\IconVariant;

    $normalizedVariant = IconVariant::normalize($variant);
    $strokeWidth = IconVariant::strokeWidth($normalizedVariant);
    $pixelSize = IconVariant::pixelSize($normalizedVariant);

    // Consumer size utilities (e.g. size-6) must win over the variant default.
    // Mixing size-4 + size-6 makes stroke weight look broken at the resolved box.
    $userClass = (string) ($attributes->get('class') ?? '');
    $hasExplicitSize = (bool) preg_match('/(?:^|\s)!?(?:size|w|h)-/', $userClass);

    $iconClasses = $hasExplicitSize
        ? 'block shrink-0'
        : IconVariant::classString($normalizedVariant);
@endphp

<svg
    {{ $attributes->class($iconClasses) }}
    @if (! $hasExplicitSize)
        width="{{ $pixelSize }}"
        height="{{ $pixelSize }}"
    @endif
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
