@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $classes = app(TypographyClassMap::class)->headingClasses(2);
@endphp

<h2 {{ $attributes->class($classes)->merge(['data-dialog-title' => true]) }}>
    {{ $slot }}
</h2>
