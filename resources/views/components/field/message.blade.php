@props([
    'variant' => 'hint',
    'invalid' => false,
])

@aware([
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\BladexComponents\Support\Typography\TypographyClassMap;

    $isError = $variant === 'error' || $invalid || $fieldInvalid;

    $toneClasses = $isError
        ? 'text-red-600 dark:text-red-400'
        : 'text-zinc-500 dark:text-zinc-400';

    $classes = collect([
        'field__message',
        $toneClasses,
        app(TypographyClassMap::class)->textClasses(
            'sm',
            $isError ? 'error' : 'subtle',
            null,
        ),
    ])->filter()->implode(' ');

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
