@aware([
    'titleId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $classes = app(TypographyClassMap::class)->headingClasses(2);
@endphp

<h2 {{ $attributes->class($classes)->merge([
    'id' => $titleId,
    'data-dialog-title' => true,
]) }}>
    {{ $slot }}
</h2>
