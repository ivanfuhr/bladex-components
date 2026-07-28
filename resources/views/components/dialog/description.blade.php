@php
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $classes = app(TypographyClassMap::class)->textClasses(null, 'subtle', null);
@endphp

<p {{ $attributes->class($classes)->merge(['data-dialog-description' => true]) }}>
    {{ $slot }}
</p>
