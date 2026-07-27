@props([
    'level' => null,
    'variant' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;
    use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;

    $level = max(1, min(6, (int) ($level ?? app(TypographyConfig::class)->defaultHeadingLevel())));
    $classes = app(TypographyClassMap::class)->headingClasses($level, $variant);
@endphp

<h{{ $level }} {{ $attributes->class($classes) }} data-heading>{{ $slot }}</h{{ $level }}>
