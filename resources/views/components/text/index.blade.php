@props([
    'size' => null,
    'variant' => null,
    'color' => null,
    'inline' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $classes = app(TypographyClassMap::class)->textClasses($size, $variant, $color);
@endphp

@if ($inline)
    <span {{ $attributes->class($classes) }} data-text>{{ $slot }}</span>
@else
    <p {{ $attributes->class($classes) }} data-text>{{ $slot }}</p>
@endif
