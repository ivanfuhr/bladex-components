@php
    $loadingVariant = std_normalize_icon_variant($variant ?? 'outline');
    $loadingIconClasses = std_icon_variant_class_string($loadingVariant);
    $loadingStrokeWidth = std_icon_variant_resolve($loadingVariant)[1];
    $loadingPixelSize = std_icon_variant_resolve($loadingVariant)[2];
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
