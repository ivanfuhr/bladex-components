@php
    $loadingVariant = \Ivanfuhr\Stencil\Support\Icon\IconVariant::normalize($variant ?? 'outline');
    $loadingIconClasses = \Ivanfuhr\Stencil\Support\Icon\IconVariant::classString($loadingVariant);
    $loadingStrokeWidth = \Ivanfuhr\Stencil\Support\Icon\IconVariant::strokeWidth($loadingVariant);
    $loadingPixelSize = \Ivanfuhr\Stencil\Support\Icon\IconVariant::pixelSize($loadingVariant);
    $loadingMergedClass = trim($loadingIconClasses.' animate-spin '.($class ?? ''));
@endphp

<svg
    class="{{ $loadingMergedClass }}"
    width="{{ $loadingPixelSize }}"
    height="{{ $loadingPixelSize }}"
    data-icon
    data-button-loading-icon
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="{{ $loadingStrokeWidth }}"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
>
    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
</svg>
