@props([
    'variant' => 'hint',
])

@php
    use Ivanfuhr\BladexComponents\Support\Typography\TypographyClassMap;

    $isError = $variant === 'error';

    $classes = app(TypographyClassMap::class)->textClasses(
        'sm',
        $isError ? 'error' : 'subtle',
        null,
    );

    $messageAttributes = $attributes
        ->class($classes)
        ->merge([
            'data-field-message' => true,
            'data-field-message-variant' => $isError ? 'error' : 'hint',
        ]);

    if ($isError) {
        $messageAttributes = $messageAttributes->merge(['role' => 'alert']);
    }
@endphp

<p {{ $messageAttributes }}>{{ $slot }}</p>
