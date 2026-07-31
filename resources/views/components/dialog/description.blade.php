@aware([
    'descriptionId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $classes = app(TypographyClassMap::class)->textClasses(null, 'subtle', null);
@endphp

<p {{ $attributes->class($classes)->merge([
    'id' => $descriptionId,
    'data-dialog-description' => true,
]) }}>
    {{ $slot }}
</p>
